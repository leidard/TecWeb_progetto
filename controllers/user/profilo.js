function onPw(evt){
	// Minimum eight characters, at least one letter and one number:
	if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(evt.target.value))
	{
		evt.target.parentElement.classList.add("error") 
		document.getElementById('Registrati').setAttribute('aria-disabled', true);
		var str="";
		var ok=true;
		if(evt.target.value.length < 8)
		{
			//non lunga abbastanza
			ok = false;
			str+="<li>Otto caratteri</li>";
		}

		if(evt.target.value.toUpperCase() == evt.target.value)
		{
			//non ha minuscole
			ok = false;
			str+="<li>una minuscola</li> "
		}

		if(evt.target.value.toLowerCase() == evt.target.value)
		{
			//non ha maiuscole
			ok = false;
			str+="<li>una maiuscola</li>"
		}

		if(!/[0-9]/g.test(evt.target.value))
		{
			//non ha numeri
			ok = false;
			str+="<li>un numero</li>"
		}

		//if(str=="")
		if(ok == true)
			str+="<li>carattere non valido presente</li>";


		document.getElementById('pw-error').innerHTML = "deve avere almeno <ul>"+str+"</ul>";
		
	}	
	else 
	{
		evt.target.parentElement.classList.remove("error")
		document.getElementById('changepw').setAttribute('aria-disabled', false);
		document.getElementById('pw-error').innerHTML = "";
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