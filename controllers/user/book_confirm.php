<?php

require_once '../components/page.php';
require_once '../components/header.php';
require_once '../components/radio_book.php';

$pagina = page('Disponibilita - Scissorhands');

$main = file_get_contents('../../views/user/book_confirm.html');

require_once __DIR__ . '/../../services/user/book.php';
require_once __DIR__ . '/../../services/public/service.php';
require_once __DIR__ . '/../../services/public/staff.php';

$user_id = 'CCC1CCC1CCC1CCC1';
if (!UserBookingService::canBook($user_id)) {
    header("Location: /user/prenotazioni.php");
}


$services = PublicServiceService::getAll();
$staff = PublicStaffService::getAll();

$selected_service = "";
if (isset($_GET["service"]) && preg_match('/^[0-9]+$/', $_GET["service"])) {
    $selected_service = $_GET["service"];
    $selected_service_name = PublicServiceService::get($selected_service)["name"];
}

$selected_staff = "";
if (isset($_GET["staff"]) && preg_match('/^[0-9]+$/', $_GET["staff"])) {
    $selected_staff = $_GET["staff"];
    $barber = PublicStaffService::get($selected_staff);
    $selected_staff_name = $barber["name"]." ".$barber["surname"];
}

$selected_day = "";
if (isset($_GET["day"]) && preg_match('/^[0-9]+$/', $_GET["day"])) {
    $selected_day = $_GET["day"];
    $selected_day_ext = gmdate("M d", $selected_day*86400);
}
$query = array(
    "staff" => $selected_staff,
    "service" => $selected_service,
    "day" => $selected_day
);
$prev_day = "/user/book_confirm.php?" . http_build_query(array(
    "staff" => $selected_staff,
    "service" => $selected_service,
    "day" => $selected_day-1
));
$next_day = "/user/book_confirm.php?" . http_build_query(array(
    "staff" => $selected_staff,
    "service" => $selected_service,
    "day" => $selected_day+1
));
$today_day = "/user/book_confirm.php?" . http_build_query(array(
    "staff" => $selected_staff,
    "service" => $selected_service,
    "day" => floor(time()/86400)
));

$main = str_replace("%PREV_DAY%", $prev_day, $main);
$main = str_replace("%NEXT_DAY%", $next_day, $main);
$main = str_replace("%TODAY_DAY%", $today_day, $main);


$backlink = "/user/book_available.php?" . http_build_query(array(
    "staff" => $selected_staff,
    "service" => $selected_service,
    "day" => $selected_day
));

$radios_slot = "";
if (!empty($selected_service) && !empty($selected_staff) && !empty($selected_day)) {
    $slots = UserBookingService::getAvailableOfDay($selected_service, $selected_staff, $selected_day * 86400);
    foreach ($slots as $slot) {
        $s = $slot["start"];
        $radios_slot .= radio_book(date("H:i", $s) . "-" . date("H:i", $slot["end"]), "time", $s, $s, false, false);
    }
} else {
    header("Location: $backlink");
}

$header = _header(array("Utente" => "/user/", "Prenotazioni" => "/user/prenotazioni.php",  "Nuova Prenotazione" => $backlink, "Orario" => $_SERVER["REQUEST_URI"]));

$main = str_replace("%RADIOS_SLOT%", $radios_slot, $main);
$main = str_replace("%SELECTED_SERVICE%", $selected_service, $main);
$main = str_replace("%SELECTED_STAFF%", $selected_staff, $main);
$main = str_replace("%SELECTED_DAY%", $selected_day, $main);

$main = str_replace("%SELECTED_DAY_EXT%", $selected_day_ext, $main);
$main = str_replace("%SELECTED_SERVICE_NAME%", $selected_service_name, $main);
$main = str_replace("%SELECTED_STAFF_NAME%", $selected_staff_name, $main);

$pagina = str_replace('%DESCRIPTION%', "Barbieria a Padova e servizi di taglio per curare il proprio look e rilassarsi", $pagina);
$pagina = str_replace('%KEYWORDS%', "scissorhands, barbiere, parrucchiere, barba, capelli, barbieria, orari", $pagina); // norme covid?
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;
