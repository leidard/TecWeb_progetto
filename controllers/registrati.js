window.onload = document.getElementById('Registrati').setAttribute('aria-disabled', true); //messo qui perch� altrimenti senza JS non pu� fare submit
var item = document.getElementById('noscript');
item.parentNode.removeChild(item);
	function clearIfError(fieldname)
	{
		if(document.getElementById(fieldname+"-error").textContent != "")
		{
			document.getElementById(fieldname).value = document.getElementById(fieldname).value.replace(/^\s+/, "").replace(/\s+$/, "").replace(/\s+/g, " ").replace(/[!@#$%^&*()\".,;:\-_+=<>1234567890\[\]\\|\{\}\/?]/g, "");
			document.getElementById(fieldname+"-error").textContent = "";
		}
	}
	
	function onEmail(evt) {
		if (!/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i.test(evt.target.value)) 
		{
			document.getElementById('Registrati').setAttribute('aria-disabled', true);
			document.getElementById('Registrati').classList.add('disabled');
			document.getElementById('mail-error').textContent = "Formato mail errato";
			
		}
		else 
		{
			document.getElementById('Registrati').setAttribute('aria-disabled', false);
			document.getElementById('Registrati').classList.remove('disabled');
			document.getElementById('mail-error').textContent = "";
		}
	}

	function onPw(evt){
		// Minimum eight characters, at least one letter and one number:
		if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(evt.target.value))
		{
			document.getElementById('Registrati').setAttribute('aria-disabled', true);
			document.getElementById('Registrati').classList.add('disabled');
			var str="";
			var ok=true;
			if(evt.target.value.length < 8)
			{
				//non lunga abbastanza
				ok = false;
				str+="<li>otto caratteri</li>";
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
				str+="<li>Carattere non valido presente</li>";


			document.getElementById('pw-error').innerHTML = "Deve avere almeno: <ul>"+str+"</ul>";
			
		}	
		else 
		{
			document.getElementById('Registrati').setAttribute('aria-disabled', false);
			document.getElementById('Registrati').classList.remove('disabled');
			document.getElementById('pw-error').innerHTML = "";
		}
	}

	function pwCheck()
	{
		if(document.getElementById("password").value !== document.getElementById("password_rep").value)
		{	
			document.getElementById('Registrati').setAttribute('aria-disabled', true);
			document.getElementById('Registrati').classList.add('disabled');
			document.getElementById('pwrep-error').textContent = "Le password non corrispondono";
			
		}
		else
		{
			document.getElementById('Registrati').setAttribute('aria-disabled', false);
			document.getElementById('Registrati').classList.remove('disabled');
			document.getElementById('pwrep-error').textContent = "";
		}
	}
	
	function sanitizeField(fieldname)
	{
		var a = document.getElementById(fieldname).value;
		
		if(a !== document.getElementById(fieldname).value.replace(/^\s+/, "").replace(/\s+$/, "").replace(/\s+/g, " ").replace(/[!@#$%^&*()\".,;:\-_+=<>1234567890\[\]\\|\{\}\/?]/g, ""))
		{
			document.getElementById(fieldname+"-error").textContent = "Carattere non valido presente";
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



	//FUNZIONI AIUTO ARIA
	function aria_onEmail(evt) {
		if (!/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i.test(evt.target.value)) 
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
		if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(evt.target.value))
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
		var a = document.getElementById(fieldname).value;
		
		if(a !== document.getElementById(fieldname).value.replace(/^\s+/, "").replace(/\s+$/, "").replace(/\s+/g, " ").replace(/[!@#$%^&*()\".,;:\-_+=<>1234567890\[\]\\|\{\}\/?]/g, ""))
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