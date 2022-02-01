window.onload = () => document.getElementById('changepw').setAttribute('aria-disabled', true); //messo qui e non sull'html perché altrimenti senza JS resterebbe sembre true. 
(function () {
	let item = document.getElementById('noscript');
	item.parentNode.removeChild(item);

})();
	function onPw(evt)
	{
		// Minimum eight characters, at least one letter and one number:
		if (!/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{9,}/.test(evt.target.value))
		{
			document.getElementById('changepw').classList.add('disabled');
			document.getElementById('changepw').setAttribute('aria-disabled', true);
			let str="";
			let ok=true;
			if(evt.target.value.length < 9)
			{
				//non lunga abbastanza
				ok = false;
				str+="<li>nove caratteri</li>";
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

			if(ok == true)
				document.getElementById('pw-error').innerHTML+="carattere non valido presente";
			else
				document.getElementById('pw-error').innerHTML = "La password deve avere: <ul>"+str+"</ul>";
			
		}	
		else 
		{
			document.getElementById('changepw').classList.remove('disabled');
			document.getElementById('changepw').setAttribute('aria-disabled', false);
			document.getElementById('pw-error').innerHTML = "";
		}
	}

	function pwCheck()
	{
		if(document.getElementById("new_password").value !== document.getElementById("confirm_new_password").value)
		{	
			document.getElementById('changepw').classList.add('disabled');
			document.getElementById('changepw').setAttribute('aria-disabled', true);
			document.getElementById('pwrep-error').textContent = "Le password non corrispondono";
		}
		else
		{
			document.getElementById('changepw').classList.remove('disabled');
			document.getElementById('changepw').setAttribute('aria-disabled', false);
			document.getElementById('pwrep-error').textContent = "";
		}
	}

	//ARIA
	function aria_onPw(evt){
		if (!/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{9,}/.test(evt.target.value))
		{
			document.getElementById('new_password').setAttribute('aria-invalid', true);
			document.getElementById('new_password').setAttribute('aria-describedby', 'pw-error');
		}	
		else 
		{
			document.getElementById('new_password').setAttribute('aria-invalid', false);
			document.getElementById('new_password').removeAttribute('aria-describedby');
		}
	}

	function aria_pwCheck()
	{
		if(document.getElementById("new_password").value !== document.getElementById("confirm_new_password").value)
		{	
			document.getElementById('confirm_new_password').setAttribute('aria-invalid', true);
			document.getElementById('confirm_new_password').setAttribute('aria-describedby', 'pwrep-error');
		}
		else
		{
			document.getElementById('confirm_new_password').setAttribute('aria-invalid', false);
			document.getElementById('confirm_new_password').removeAttribute('aria-describedby');
		}
	}



	function preventSubmit(event)
	{
		arr = document.getElementsByTagName('input');
		for(let a=0; a<arr.length; a++)
		{
			if(arr[a].getAttribute('aria-invalid')=="true")
			{
				event.preventDefault();
				arr[a].focus();
				break;
			}
		}
	}