window.onload = () => document.getElementById('login').setAttribute('aria-disabled', true);

function onEmail(evt) {
	if (!/^([a-z0-9\+_\-]{3,})(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]{3,}\.)[a-z]{2,6}$/i.test(evt.target.value) && evt.target.value !== "admin" && evt.target.value !== "user") {
		document.getElementById('login').setAttribute('aria-disabled', true);
		document.getElementById('login').classList.add('disabled');
		document.getElementById('mail').setAttribute('aria-invalid', true);
		document.getElementById('email-error').textContent = "Formato email non valido";
	}
	else {
		document.getElementById('login').setAttribute('aria-disabled', false);
		document.getElementById('login').classList.remove('disabled');
		document.getElementById('mail').setAttribute('aria-invalid', false);
		document.getElementById('email-error').textContent = "";
	}
}

function onPw(evt) {
	if (!/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{9,}/.test(evt.target.value) && evt.target.value !== "admin" && evt.target.value !== "user") {
		document.getElementById('login').setAttribute('aria-disabled', true);
		document.getElementById('login').classList.add('disabled');
		document.getElementById('password').setAttribute('aria-invalid', true);
	}
	else {
		document.getElementById('login').setAttribute('aria-disabled', false);
		document.getElementById('login').classList.remove('disabled');
		document.getElementById('password').setAttribute('aria-invalid', false);
	}
}

function preventSubmit(event) {
	arr = document.getElementsByTagName('input');
	for (let a = 0; a < arr.length; a++) {
		if (arr[a].getAttribute('aria-invalid') == "true") {
			event.preventDefault();
			arr[a].focus();
			break;
		}
	}
}