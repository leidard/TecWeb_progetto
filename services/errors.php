<?php

class ReservationPendingError extends Error {
    public function __construct(){
        parent::__construct("Impossibile prenotare, in attesa della conferma della precedente prenotazione.");
    }
}

class ReservationSlotsError extends Error {
    public function __construct() {
        parent::__construct("Orario Prenotazione Non Valido");
    }
}