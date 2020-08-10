console.log("подключен js feedback_kvv_2_0");

async function sendMessage(modal_form) {
	event.preventDefault();
	let form = document.getElementById(modal_form);
	let formData = new FormData(form);
	formData.append("submit", "submit");
	formData.append("dataTime", dataTime());
	formData.append("modal_form", modal_form);

	if (errorForm(form)) {
		return false;
	}

	let response = await fetch('', {
		method: 'POST',
		body: formData
	});

	let result = await response.text();

	document.getElementById(modal_form).hidden = true;

	send_mes.innerHTML = result;
}

function dataTime() {
	Data = new Date();

	Year = Data.getFullYear();
	Month = Data.getMonth();
	nDate = Data.getDate()

	Hour = Data.getHours();
	Minutes = Data.getMinutes();
	Seconds = Data.getSeconds();

	return nDate + "." + Month + "." + Year + " - " + Hour + ":" + Minutes + ":" + Seconds;
}

function errorForm(form){
	let errorSum = 0;
	let elemRequired =  form.querySelectorAll("[required]");

	if(elemRequired.length = 0 ){
		return true;
	}

	elemRequired.forEach(function(item){
		let value = item.value;
		if(item.value == "")
		{
			if(!item.classList.contains("input_error")) item.classList.add("input_error");
			errorSum = errorSum + 1;
		}
		else
		{
			if(item.classList.contains("input_error")) item.classList.remove("input_error");
		}
	});


	/* Проверка на СПАМ */
	if(form.querySelector('[name="check"]').value !== 'secretcode'){
		console.log('Spam error!!!');
		errorSum = errorSum + 1;
	}
	// результат
	if (errorSum > 0) {
		return true;
	}
	else {
		return false;
	}
}

