(function() {
	let openEl = document.getElementById('open_at');
	let closeEl = document.getElementById('close_at');
	let error = document.getElementById('orario-error');
	let change = document.getElementById('change');

	function refresh() {
		closeEl.setAttribute('min', openEl.valueAsNumber+1 || 0);
		openEl.setAttribute('max', closeEl.valueAsNumber-1 || 23);
	}
	refresh();

	function check(event)
	{
		error.innerText="";
		error.removeAttribute("aria-live");
		if(closeEl.valueAsNumber<=openEl.valueAsNumber)
		{
			event.preventDefault();
			error.innerText="L'apertura deve precedere la chiusura.";
			error.setAttribute("aria-live","polite");
			refresh();
		}
		if(closeEl.valueAsNumber > 23)
		{
			event.preventDefault();
			error.innerText="Orario chiusura non valido.";
			error.setAttribute("aria-live","polite");
		}
		if(openEl.valueAsNumber < 0)
		{
			event.preventDefault();
			error.innerText="Orario apertura non valido.";
			error.setAttribute("aria-live","polite");

		}
	}

	change.onclick = check;

	openEl.oninput = refresh;
	closeEl.oninput = refresh;



})();