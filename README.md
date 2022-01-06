# 💈Barber Scissorhands

## Dev Server

per fare girare un dev server
```bash
php -S localhost:8000 -t controllers/
```

###

```php
$template_pagina = file_get_contents('../view/home.html');
$pagina = str_replace('%TITOLO%', "Home" , $template_pagina);

```

###


```typescript

function getOrariFrom(timeUT: number, deltaTaglio: number, parrucchiere: idparruchiere) {
    const { 
        open_at,
        closes_at,
        days 
    } = getAzienda();

    // giorno di apertura
    const dayOfWeek = getDayOfWeek(time);
    if (days[dayOfWeek]) // accept
    else // reject

    // reintra negli orari validi
    const nSecdainiziogiornata = timeUT % 86400;
    if (open_at < nSecdainiziogiornata < closes_at) // accept
    else // reject

    
    const prenotazioni = getPrenotazioniFrom(time, parrucchiere);

    const fasce = [];
    let lastTime = open_at;
    foreach(prenotazione in prenotazioni) {
        let nP = Math.floor((prenotazione.start - lastTime) / deltaTaglio)

        for (let i = 0; i < nP; i++, lastT += deltaTaglio) fasce.append({
            start: lastT,
            duration: deltaTagli,
            end: lastT + deltaTaglio,
        })
        // POST = lastT === fasce[fasce.length-1].end;

        lastTime = prenotazione.end;
    }
}

```


```javascript

window.onload = function() {
    let el = document.getById('prenotazion-barbiere');
    let el2 = document.getElementById('prenotazion-taglio');


    el.onclick = function() {
        this.setAttribute('aria-hidden', 'true');
        el2.setAttribute('aria-hidden', 'false');
    }
}

```