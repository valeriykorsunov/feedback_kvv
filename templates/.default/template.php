<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
	$idForm = "contactForm";
?>
<h2>Форма обратной связи.</h2>

<div id="send_mes"> Сообщение будет отправлено.</div>

<form id="<?=$idForm?>">
	<input type="hidden" name="check" value="" id="check" />
	<input type="hidden" name="PARAM_MESSAGE_ID" value="7">
	
	<? // Для указания продукта по которому отправлена форма ?>
	<input type="hidden" name="PARAM_PRODUCT_NAME" value="Test - PRODUCT_NAME">
	<input type="hidden" name="PARAM_PRODUCT_ID" value="Test - PRODUCT_ID">


	<input type="text" name="user_name" placeholder="Ваше имя" required>
	<br>
	<input type="email" name="user_email" placeholder="E-mail" required>
	<br>
	<input type="text" name="phone" placeholder="Контактный телефон" required>
	<br>
	<input type="file" name="file" placeholder="Файл" >
	<br>
	<button onclick='document.getElementById("check").value = "secretcode"; sendMessage("<?=$idForm?>");'>Отправить</button>
</form>