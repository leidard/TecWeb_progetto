function onPw(evt){
			if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(evt.target.value) && evt.target.value !== "admin" && evt.target.value !== "user")
			{
				evt.target.parentElement.classList.add("error");
				document.getElementById('changepw').setAttribute('aria-disabled', 'true');
				document.getElementsByClassName('pw-error')[0].textContent = "Minimo 8 caratteri, tra cui almeno una lettera e un numero";
			}
			else
			{ 
				evt.target.parentElement.classList.remove("error");
				document.getElementById('changepw').setAttribute('aria-disabled', 'false');
				document.getElementsByClassName('pw-error')[0].textContent = "";
			}
		}

		function pwCheck(evt)
		{
			if(document.getElementById("new_password").value !== document.getElementById("confirm_new_password").value)
			{	
				evt.target.parentElement.classList.add("error");
				document.getElementById('changepw').disabled = true;
				document.getElementsByClassName('pwrep-error')[0].textContent = "Le password non corrispondono";
			}
			else
			{
				evt.target.parentElement.classList.remove("error");
				document.getElementById('changepw').disabled = false;
				document.getElementsByClassName('pwrep-error')[0].textContent = "";
			}
		}