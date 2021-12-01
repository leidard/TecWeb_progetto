# 💈Barber Scissorhands

```typescript

function getOrariFrom(timeUT: number) {
    const { 
        open_at,
        closes_at,
        days 
    } = getAzienda();

    // giorno di apertura
    const dayOfWeek = getDayOfWeek(time);
    if (days[dayOfWeek]) // accept
    else // reject

    // 
    const inizioGiornoUT = timeUT % 86400;
    if (open_at < inizioGiornoUT < closes_at) // accept
    else // reject

    const preontazioni = getProntazioniFrom(time, )
}

```