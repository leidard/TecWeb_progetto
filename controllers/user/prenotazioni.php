<?php

require_once '../components/page.php';
require_once '../components/header.php';
require_once '../components/booked_pending.php';
require_once '../components/booked_row.php';
require_once '../components/breadcrumb.php';

$pagina = page('Prenotazioni Utente');
$header = _header(array("Utente" => "/user/", "Prenotazioni" => "/user/prenotazioni.php"));
$main = file_get_contents('../../views/user/prenotazioni.html');

require_once __DIR__ . '/../../services/user/book.php';
require_once __DIR__ . '/../../services/errors.php';

// TODO CHANGE USER_ID
$user_id = 1;


// RICEZIONE DI NUOVA PRENOTAZIONE
if (isset($_POST) && !empty($_POST)) {
    $book = array(
        "staff" => NULL,
        "service" => NULL,
        "time" => NULL,
    );
    if (isset($_POST["staff"]) && preg_match('/^[0-9]+$/', $_POST["staff"])) {
        $book["staff"] = $_POST["staff"];
    } else return;
    if (isset($_POST["service"]) && preg_match('/^[0-9]+$/', $_POST["service"])) {
        $book["service"] = $_POST["service"];
    } else return;
    if (isset($_POST["time"]) && preg_match('/^[0-9]+$/', $_POST["time"])) {
        $book["time"] = $_POST["time"];
    } else return;


    if ($book["staff"] !== NULL && $book["service"] !== NULL && $book["time"] !== NULL) {

        try {
            UserBookingService::createReservation($user_id, $book["service"], $book["staff"], $book["time"]);
        } catch (ReservationPendingError $error) {
            echo $error->getMessage() . "";
        } catch (ReservationSlotsError $error) {
            echo $error->getMessage() . "";
        }
    }
}


// STAMPA NON CONFERMATO SE PRESENTE
$unc =  UserBookingService::getUnconfirmed($user_id);
$unc_str = "";
if (!!$unc) {
    $unc_str = booked_pending($unc["start_at"], $unc["end_at"], $unc["service"], $unc["price"], $unc["staff"]);
} else {
    $unc_str = "Nessuna";
}
$main = str_replace("%UNCONFIRMED%", $unc_str, $main);


// STAMPA TUTTE LE PRENOTAZIONI PASSATE
$resv =  UserBookingService::getAll($user_id);
$str = "";
foreach ($resv as $r) {
    $str .= booked_row($r["start_at"], $r["end_at"], $r["service"], $r["price"], $r["staff"]);
}
$main = str_replace("%BOOKINGS%", $str, $main);


$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;
