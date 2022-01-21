window.onload = document.getElementById('Registrati').setAttribute('disabled', true); //messo qui perch� altrimenti senza JS non pu� fare submit
		var ariapwtest=false;
		function clearIfError(fieldname)
		{
			if(document.getElementById(fieldname+"-error").textContent === "Caratteri non validi presenti")
			{
				document.getElementById(fieldname).value = document.getElementById(fieldname).value.replace(/^\s+/, "").replace(/\s+$/, "").replace(/\s+/g, " ").replace(/[!@#$%^&*()\".,;:\-_+=<>1234567890\[\]\\|\{\}\/?]/g, "");
				document.getElementById(fieldname+"-error").textContent = "";
			}
		}
		
		function onEmail(evt) {
			if (!/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i.test(evt.target.value)) 
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
				var str="";
				if(evt.target.value.length < 8)
				{
					//non lunga abbastanza
					str+="<li>Otto caratteri</li>";
				}
	
				if(evt.target.value.toUpperCase() == evt.target.value)
				{
					//non ha minuscole
					str+="<li>una minuscola</li> "
				}
	
				if(evt.target.value.toLowerCase() == evt.target.value)
				{
					//non ha maiuscole
					str+="<li>una maiuscola</li>"
				}
	
				if(!/[0-9]/g.test(evt.target.value))
				{
					//non ha numeri
					str+="<li>un numero</li>"
				}

				document.getElementById('pw-error').innerHTML = "deve avere almeno <ul>"+str+"</ul>";
				ariapwtest = true;
			}	
			else 
			{
				evt.target.parentElement.classList.remove("error")
				document.getElementById('Registrati').disabled = false;
				document.getElementById('pw-error').innerHTML = "";
				ariapwtest = false;
				
			}
		}

		function pwCheck(evt)
		{
			if(document.getElementById("password").value !== document.getElementById("password_rep").value)
			{	
				evt.target.parentElement.classList.add("error");
				document.getElementById('Registrati').disabled = true;
				document.getElementById('pwrep-error').textContent = "Le password non corrispondono";
			}
			else
			{
				evt.target.parentElement.classList.remove("error");
				document.getElementById('Registrati').disabled = false;
				document.getElementById('pwrep-error').textContent = "";
			}
		}
	 
		function sanitizeField(fieldname)
		{
			var a = document.getElementById(fieldname).value;
			
			if(a !== document.getElementById(fieldname).value.replace(/^\s+/, "").replace(/\s+$/, "").replace(/\s+/g, " ").replace(/[!@#$%^&*()\".,;:\-_+=<>1234567890\[\]\\|\{\}\/?]/g, ""))
			{
				document.getElementById(fieldname+"-error").textContent = "Caratteri non validi presenti";
			}
			else
			{
				document.getElementById(fieldname+"-error").textContent = "";	
			}
		}

		//ARIA STUFF
		function aria_onEmail(evt) {
			if (!/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i.test(evt.target.value)) 
			{
				document.getElementById('Registrati').setAttribute('aria-invalid', true);
			}
			else 
			{
				document.getElementById('Registrati').setAttribute('aria-invalid', false);
			}
		}

		function aria_onPw(evt){
			if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(evt.target.value))
			{
				document.getElementById('password').setAttribute('aria-invalid', true);
			}	
			else 
			{
				document.getElementById('password').setAttribute('aria-invalid', false);
			}
		}

		function aria_pwCheck(evt)
		{
			if(document.getElementById("password").value !== document.getElementById("password_rep").value)
			{	
				document.getElementById('password_rep').setAttribute('aria-invalid', true);
			}
			else
			{
				document.getElementById('password_rep').setAttribute('aria-invalid', false);
			}
		}
	 
		function aria_sanitizeField(fieldname)
		{
			var a = document.getElementById(fieldname).value;
			
			if(a !== document.getElementById(fieldname).value.replace(/^\s+/, "").replace(/\s+$/, "").replace(/\s+/g, " ").replace(/[!@#$%^&*()\".,;:\-_+=<>1234567890\[\]\\|\{\}\/?]/g, ""))
			{
				document.getElementById(fieldname).setAttribute('aria-invalid', true);
			}
			else
			{
				document.getElementById(fieldname).setAttribute('aria-invalid', false);
			}
		}