<?php

require_once '../components/page.php';
require_once '../components/header.php';
require_once '../components/booked_pending.php';
require_once '../components/booked_row.php';
require_once '../components/breadcrumb.php';
require_once '../components/meta_index.php';

$pagina = page('Prenotazioni utente - Scissorhands');

$meta_index = _meta_index(false);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$header = _header(array("Prenotazioni" => "/user/prenotazioni.php"));
$main = file_get_contents('../../views/user/prenotazioni.html');

require_once __DIR__ . '/../../services/user/book.php';
require_once __DIR__ . '/../../services/errors.php';

if (session_status() === PHP_SESSION_NONE)
    session_start();

if (!isset($_SESSION["sessionid"])) {
    header("Location: /accedi.php");
    die();
}
if ($_SESSION["type"] != "USER") {
    header("Location: /staff/prenotazioni.php");
    die();
}
$user_id = $_SESSION["sessionid"];

// RICEZIONE DI NUOVA PRENOTAZIONE
function handleBook($user) {
    $book = array(
        "staff" => NULL,
        "service" => NULL,
        "time" => NULL,
    );
    $error = "";
    if (isset($_POST["staff"]) && preg_match('/^[0-9]+$/', $_POST["staff"])) {
        $book["staff"] = $_POST["staff"];
    } else {
        $error .= "Barbiere mancante, ";
    }
    if (isset($_POST["service"]) && preg_match('/^[0-9]+$/', $_POST["service"])) {
        $book["service"] = $_POST["service"];
    } else {
        $error .= "Servizio mancante, ";
    }
    if (isset($_POST["time"]) && preg_match('/^[0-9]+$/', $_POST["time"])) {
        $book["time"] = $_POST["time"];
    } else {
        $error .= "Orario di inizio prenotazione mancante";
    }

    if ($error !== "") {
        // errore per gestire i furbetti che aggirano il sistema
        return "Errore Nella Prenotazione: $error";
    }


    if ($book["staff"] !== NULL && $book["service"] !== NULL && $book["time"] !== NULL) {
        try {
            UserBookingService::createReservation($user, $book["service"], $book["staff"], $book["time"]);
            return;
        } catch (ReservationPendingError $err) {
            $error = $err->getMessage();
        } catch (ReservationSlotsError $err) {
            $error = $err->getMessage();
        }
    }
    if ($error !== "") {
        return $error;
    }
}

$err = "";
if (isset($_POST) && !empty($_POST)) {
    $err = handleBook($user_id);
}


// STAMPA NON CONFERMATO SE PRESENTE ALTRIMENTI LINK CREA NUOVA PRENOTAZIONE
$unc =  UserBookingService::getUnconfirmed($user_id);
$unc_str = "";
if (!!$unc) {
    $unc_str = booked_pending($unc["start_at"], $unc["end_at"], $unc["service"], $unc["price"], $unc["staff"]);
} else if ($err !== "") {
    $unc_str = '<p>
    <span class="line">' . $err . '</span>
    <span class="line">Sembra che tu non debba essere qua🤔. Ritenta, sarai più forunato 😉!</span>
    <span class="line"><a href="/user/prenota.php">Clicca qui per ritentare la prenotazione</a>.</span>
    </p>';
} else {
    $unc_str = '<p>Non c\'è nessuna prenotazione in attesa, <a href="/user/prenota.php">clicca qui per crearne una nuova</a>.</p>';
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
