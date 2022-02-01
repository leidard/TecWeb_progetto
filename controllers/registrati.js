window.onload = () => document.getElementById('Registrati').setAttribute('aria-disabled', true); //messo qui e non sull'html perché altrimenti senza JS resterebbe sembre true. 
(function () {
	let item = document.getElementById('noscript');
	item.parentNode.removeChild(item);


})();
	function clearIfError(fieldname)
	{
		if(document.getElementById(fieldname+"-error").textContent != "")
		{
			document.getElementById(fieldname).value = document.getElementById(fieldname).value.replace(/^\s+/, "").replace(/\s+$/, "").replace(/\s+/g, " ").replace(/[!£€§@#$%^&*()\".,;:\-_+=<>1234567890\[\]\\|\{\}\/?]/g, "");
			document.getElementById(fieldname+"-error").textContent = "";
		}
	}
	
	function onEmail(evt) {
		if (!/^([a-z0-9\+_\-]{3,})(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]{3,}\.)[a-z]{2,6}$/i.test(evt.target.value)) 
		{
			document.getElementById('Registrati').setAttribute('aria-disabled', true);
			document.getElementById('Registrati').classList.add('disabled');
			document.getElementById('mail-error').textContent = "Formato mail errato.";
			
		}
		else 
		{
			if(document.getElementById("password").value === document.getElementById("password_rep").value 
				&& /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{9,}/.test(document.getElementById("password").value))
			{
				document.getElementById('Registrati').setAttribute('aria-disabled', false);
				document.getElementById('Registrati').classList.remove('disabled');
			}
			document.getElementById('mail-error').textContent = "";
		}
	}

	function onPw(){
		let pw = document.getElementById("password").value;
		if (!/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{9,}/.test(pw))
		{
			document.getElementById('Registrati').setAttribute('aria-disabled', true);
			document.getElementById('Registrati').classList.add('disabled');
			let str="";
			let ok=true;
			if(pw.length < 9)
			{
				//non lunga abbastanza
				ok = false;
				str+="<li>nove caratteri</li>";
			}

			if(pw.toUpperCase() == pw)
			{
				//non ha minuscole
				ok = false;
				str+="<li>una minuscola</li> "
			}

			if(pw.toLowerCase() == pw)
			{
				//non ha maiuscole
				ok = false;
				str+="<li>una maiuscola</li>"
			}

			if(!/[0-9]/g.test(pw))
			{
				//non ha numeri
				ok = false;
				str+="<li>un numero</li>"
			}

			if(ok == true)
				document.getElementById('pw-error').innerHTML ="Carattere non valido presente";
			else
				document.getElementById('pw-error').innerHTML = "La password deve avere: <ul>"+str+"</ul>";
		}	
		else 
		{
			if(document.getElementById("password").value === document.getElementById("password_rep").value 
				&& document.getElementById('mail').getAttribute('aria-invalid') != true)
			{
				document.getElementById('Registrati').setAttribute('aria-disabled', false);
				document.getElementById('Registrati').classList.remove('disabled');
			}
			document.getElementById('pw-error').innerHTML = "";
		}
	}

	function pwCheck()
	{
		if(document.getElementById("password").value !== document.getElementById("password_rep").value)
		{	
			document.getElementById('Registrati').setAttribute('aria-disabled', true);
			document.getElementById('Registrati').classList.add('disabled');
			document.getElementById('pwrep-error').textContent = "Le password non corrispondono.";
			
		}
		else 
		{
			if(/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{9,}/.test(document.getElementById("password").value) 
			&& document.getElementById('mail').getAttribute('aria-invalid') != true)
			{	
				document.getElementById('Registrati').setAttribute('aria-disabled', false);
				document.getElementById('Registrati').classList.remove('disabled');
			}
			document.getElementById('pwrep-error').textContent = "";
		}
	}
	
	function sanitizeField(fieldname)
	{
		let a = document.getElementById(fieldname).value;
		
		if(a !== document.getElementById(fieldname).value.replace(/^\s+/, "").replace(/\s+$/, "").replace(/\s+/g, " ").replace(/[£€§!@#$%^&*()\".,;:\-_+=<>1234567890\[\]\\|\{\}\/?]/g, ""))
		{
			document.getElementById(fieldname+"-error").textContent = "Carattere non valido presente.";
			document.getElementById('Registrati').setAttribute('aria-disabled', true);
			document.getElementById('Registrati').classList.add('disabled');
		}
		else
		{
			document.getElementById(fieldname+"-error").textContent = "";	
			document.getElementById('Registrati').setAttribute('aria-disabled', false);
			document.getElementById('Registrati').classList.remove('disabled');
		}
	}



	//FUNZIONI PER ARIA
	function aria_onEmail(evt) {
		if (!/^([a-z0-9\+_\-]{3,})(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]{3,}\.)[a-z]{2,6}$/i.test(evt.target.value)) 
		{
			document.getElementById('mail').setAttribute('aria-invalid', true);
			document.getElementById('mail').setAttribute('aria-describedby', 'mail-error');
		}
		else 
		{
			document.getElementById('mail').setAttribute('aria-invalid', false);
			document.getElementById('mail').removeAttribute('aria-describedby');
		}
	}

	function aria_onPw(evt){
		if (!/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{9,}/.test(evt.target.value))
		{
			document.getElementById('password').setAttribute('aria-invalid', true);
			document.getElementById('password').setAttribute('aria-describedby', 'pw-error');
		}	
		else 
		{
			document.getElementById('password').setAttribute('aria-invalid', false);
			document.getElementById('password').removeAttribute('aria-describedby');
		}
	}

	function aria_pwCheck()
	{
		if(document.getElementById("password").value !== document.getElementById("password_rep").value)
		{	
			document.getElementById('password_rep').setAttribute('aria-invalid', true);
			document.getElementById('password_rep').setAttribute('aria-describedby', 'pwrep-error');
		}
		else
		{
			document.getElementById('password_rep').setAttribute('aria-invalid', false);
			document.getElementById('password_rep').removeAttribute('aria-describedby');
		}
	}
	
	function aria_sanitizeField(fieldname)
	{
		let a = document.getElementById(fieldname).value;
		
		if(a !== document.getElementById(fieldname).value.replace(/^\s+/, "").replace(/\s+$/, "").replace(/\s+/g, " ").replace(/[!£€§@#$%^&*()\".,;:\-_+=<>1234567890\[\]\\|\{\}\/?]/g, ""))
		{
			document.getElementById(fieldname).setAttribute('aria-invalid', true);
			document.getElementById(fieldname).setAttribute('aria-describedby', fieldname+'-error');
		}
		else
		{
			document.getElementById(fieldname).setAttribute('aria-invalid', false);
			document.getElementById(fieldname).removeAttribute('aria-describedby');

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