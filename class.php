<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Page\Asset;

class Cfeedback extends CBitrixComponent
{
	/*
	 * метод executeComponent исполнянется вместо component.php
	 */
	function executeComponent() 
    {
		/**
		 * startResultCache - Возвращает True в случае, если кеш недействителен, или False в противном случае. 
		 **/
		if($this->startResultCache() && $_SERVER["REQUEST_METHOD"] !== "POST")
		{
			Asset::getInstance()->addJs($this->GetPath().'/script.js');
			Asset::getInstance()->addCss($this->GetPath().'/style.css');

			$this->includeComponentTemplate(); 
		}

		if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"] <> '' && $_POST['check'] == "secretcode")
		{
			$GLOBALS['APPLICATION']->RestartBuffer();
		
			$sentemail = $this->sendMailBx($_POST['PARAM_MESSAGE_ID']);
			
			if ($sentemail)
			{
				html_message_ok();
			}
			else
			{
				echo "Ошибка отправки сообщения";
			}

			die();
		}
	}
	
	/** Отправка сообщения используюя функцию битрикс
	 * 
	 */
	function sendMailBx($message_id = 7)
	{
		$fileId = "";
		if ($_FILES["file"]['type']) 
		{
			$filePath = $_FILES["file"]['tmp_name'];
			$fileId = CFile::SaveFile(
				array(
					"name" => $_FILES["file"]['name'],   // имя файла, как оно будет в письме
					"size" => $_FILES["file"]['size'],   // работает и без указания размера
					"tmp_name" => $filePath,                    // собственно файл
					// "type" => "",                            // тип, не ясно зачем
					"old_file" => "0",                          // ID "старого" файла
					"del" => "N",                               // удалять прошлый?
					"MODULE_ID" => "",                          // имя модуля, работает и так
					"description" => "",                        // описание
					// "content" => "содержимое файла"          // если указать, то вместо файла будет указанный текст
				),
				'mails',  // относительный путь от upload, где будут храниться файлы
				false,    // ForceMD5
				false     // SkipExt
			);
		}

		$event = 'FEEDBACK_FORM';
		$site_id = SITE_ID;
		$arFields = Array(
			"AUTHOR" => $_POST["user_name"],
			"AUTHOR_EMAIL" => $_POST["user_email"],
			"PHONE" => $_POST["phone"],
			"TEXT" => $_POST["message"],
			"DATA_TIME" => $_POST["dataTime"],
			"PRODUCT_ORDER" => $_POST["PRODUCT_ORDER"]
		);

		$result = CEvent::Send($event , $site_id, $arFields, '', $message_id, array($fileId));

		if ($_FILES["file"]['type']) CFile::Delete($fileId);
		
		return $result;
	}

	private function html_message_ok()
	{?>
		<?if($_POST['modal_form'] == 'formPopUp'):?>

		<?else:?>
			Сообщение отправлено.
		<?endif;?>
	<?}

}?>