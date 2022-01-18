window.onload = document.getElementById('Registrati').setAttribute('disabled', true); //messo qui perché altrimenti senza JS non può fare submit

		function onEmail(evt) {
			if (!/^([\w-+.]+)@([\w-+.]+).([\w-+.]+)$/.test(evt.target.value)) 
			{
				evt.target.parentElement.classList.add("error");
				document.getElementById('Registrati').setAttribute('aria-disabled', true);
				document.getElementsByClassName('email-error')[0].textContent = "La mail deve essere del formato nomeutente@dominio.it";
				
			}
			else 
			{
				evt.target.parentElement.classList.remove("error");
				document.getElementById('Registrati').setAttribute('aria-disabled', false);
				document.getElementsByClassName('email-error')[0].textContent = "";
			}
		}

		function onPw(evt){
			// Minimum eight characters, at least one letter and one number:
			if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(evt.target.value))
			{
				evt.target.parentElement.classList.add("error") 
				document.getElementById('Registrati').disabled = true;
				document.getElementsByClassName('pw-error')[0].innerHTML = "La password deve avere almeno <ul> <li> 8 caratteri</li> <li>una maiuscola</li> <li>una minuscola</li> <li>un numero</li>";
				
			}
			else 
			{
				evt.target.parentElement.classList.remove("error")
				document.getElementById('Registrati').disabled = false;
				document.getElementsByClassName('pw-error')[0].innerHTML = "";
				
			}
		}

		function pwCheck(evt)
		{
			if(document.getElementById("password").value !== document.getElementById("password_rep").value)
			{	
				evt.target.parentElement.classList.add("error");
				document.getElementById('Registrati').disabled = true;
				document.getElementsByClassName('pwrep-error')[0].textContent = "Le password non corrispondono";
			}
			else
			{
				evt.target.parentElement.classList.remove("error");
				document.getElementById('Registrati').disabled = false;
				document.getElementsByClassName('pwrep-error')[0].textContent = "";
			}
		}
	 
		function sanitizeField(fieldname)
		{
			//document.getElementById(fieldname).value = document.getElementById(fieldname).value.replace(/^\s+/, "").replace(/\s+$/, "").replace(/\s+/g, " ").replace(/[!@#$%^&*()1234567890\[\]\\|\{\}\/?]/g, "");
			
			var a = document.getElementById(fieldname).value;
			
			if(a !== document.getElementById(fieldname).value.replace(/^\s+/, "").replace(/\s+$/, "").replace(/\s+/g, " ").replace(/[!@#$%^&*()'".,;:\-_+=<>1234567890\[\]\\|\{\}\/?]/g, ""))
			{
				document.getElementsByClassName(fieldname+"-error")[0].textContent = "Caratteri non validi presenti";
			}
			else
			{
				document.getElementsByClassName(fieldname+"-error")[0].textContent = "";	
			}
		}

		function clearIfError(fieldname)
		{
			if(document.getElementsByClassName(fieldname+"-error")[0].textContent === "Caratteri non validi presenti")
			{
				document.getElementById(fieldname).value = document.getElementById(fieldname).value.replace(/^\s+/, "").replace(/\s+$/, "").replace(/\s+/g, " ").replace(/[!@#$%^&*().,;:-_+=<>1234567890\[\]\\|\{\}\/?]/g, "");
				document.getElementsByClassName(fieldname+"-error")[0].textContent = "";
			}
		}