# 💈 Barbieria Scissorhands 💈

## Regolamento di progetto
- Il sito web deve essere realizzato con lo standard XHTML Strict, o HTML5. Le pagine in HTML5 devono degradare in modo elegante e devono rispettare la sintassi XML;
- il layout deve essere realizzato con CSS puri (CSS2 o CSS3);
- l’uso dei layout Flex e Grid, se sviluppati in maniera corretta ed utilizzati ragionevolmente, vengono valutati molto positivamente;
- il sito web deve rispettare la completa separazione tra contenuto, presentazione e comportamento;
- il sito web deve essere accessibile a tutte le categorie di utenti;
- il sito web deve organizzare i propri contenuti in modo da poter essere facilmente reperiti da qualsiasi utente;
- il sito web deve contenere pagine che utilizzino script PHP per collezionare e pubblicare dati inseriti dagli utenti (deve essere sviluppata anche la possibilità di modifica e cancellazione dei dati stessi);
- deve essere presente una forma di controllo dell’input inserito dall’utente, sia lato client che lato server;
- i dati inseriti dagli utenti devono essere salvati in un database;
- è preferibile che il database sia in forma normale.

## Note aggiuntive
Non possono essere usate librerie o framework.


Devono essere rispettate le regole di accessibilità ufficiali del W3: [W3.org](https://www.w3.org/standards/webdesign/accessibility)


Test per valutare l'accessibilità: [WCAG Tester](https://web.math.unipd.it/accessibility/index.html)
## Dev Server

per fare girare un dev server
```bash
php -S localhost:8000 -t controllers/
```

###

```php
$template_pagina = file_get_contents('../view/index.html');
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
