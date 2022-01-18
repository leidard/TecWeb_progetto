window.onload = document.getElementById('login').setAttribute('aria-disabled', true); //messo qui perché altri senza JS non può fare submit

		function onEmail(evt) {
			if (!/^([\w-+.]+)@([\w-+.]+).([\w-+.]+)$/.test(evt.target.value) && evt.target.value !== "admin" && evt.target.value !== "user") 
			{
				evt.target.parentElement.classList.add("error");
				document.getElementById('login').setAttribute('aria-disabled', 'true');
				document.getElementsByClassName('email-error')[0].textContent = "La mail deve essere del formato nomeutente@dominio.it";
				
			}
			else 
			{
				evt.target.parentElement.classList.remove("error");
				document.getElementById('login').setAttribute('aria-disabled', 'false');
				document.getElementsByClassName('email-error')[0].textContent = "";
			}
		}

		function onPw(evt){
			// Minimum eight characters, at least one letter and one number:
			if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(evt.target.value) && evt.target.value !== "admin" && evt.target.value !== "user")
			{
				evt.target.parentElement.classList.add("error");
				document.getElementById('login').setAttribute('aria-disabled', 'true');
			}
			else
			{ 
				evt.target.parentElement.classList.remove("error");
				document.getElementById('login').setAttribute('aria-disabled', 'false');
			}
		}
