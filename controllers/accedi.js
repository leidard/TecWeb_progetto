window.onload = document.getElementById('login').setAttribute('aria-disabled', true); //messo qui perch� altri senza JS non pu� fare submit

		function onEmail(evt) {
			if (!/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i.test(evt.target.value) && evt.target.value !== "admin" && evt.target.value !== "user") 
			{
				evt.target.parentElement.classList.add("error");
				document.getElementById('login').setAttribute('aria-disabled', 'true');
				document.getElementById('email-error').textContent = "La mail deve essere del formato nomeutente@dominio.it";
				
			}
			else 
			{
				evt.target.parentElement.classList.remove("error");
				document.getElementById('login').setAttribute('aria-disabled', 'false');
				document.getElementById('email-error').textContent = "";
			}
		}

		function onPw(evt){
			// Minimum eight characters, at least one letter and one number:
			if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(evt.target.value) && evt.target.value !== "admin" && evt.target.value !== "user")
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
				document.getElementById('Registrati').setAttribute('aria-disabled', false);
				document.getElementById('pw-error').innerHTML = "";
			}
		}
