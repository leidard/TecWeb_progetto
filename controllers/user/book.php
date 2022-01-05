<?php
require_once '../components/page.php';
require_once '../components/header.php';
require_once '../components/radio_book.php';
require_once '../components/breadcrumb.php';

$pagina = page('Prenota');
$header = _header();
$main = file_get_contents('../../views/user/book.html');

require_once __DIR__ . '/../../services/user/book.php';
require_once __DIR__ . '/../../services/public/service.php';
require_once __DIR__ . '/../../services/public/staff.php';

$services = PublicServiceService::getAll();
$staff = PublicStaffService::getAll();

$selected_service = "";
if (isset($_GET["service"]) && preg_match('/^[0-9]+$/', $_GET["service"])) {
    $selected_service = $_GET["service"];
}

$selected_staff = "";
if (isset($_GET["staff"]) && preg_match('/^[0-9]+$/', $_GET["staff"])) {
    $selected_staff = $_GET["staff"];
}

$selected_day = "";
if (isset($_GET["day"]) && preg_match('/^[0-9]+$/', $_GET["day"])) {
    $selected_day = $_GET["day"];
}

$radios_slot = "";
if (!empty($selected_service) && !empty($selected_staff) && !empty($selected_day)) {
    $slots = UserBookingService::getAvailableOfDay($selected_service, $selected_staff, $selected_day * 86400);
    foreach ($slots as $slot) {
        $s = $slot["start"];
        $radios_slot .= radio_book(date("H:i", $s) . "-" . date("H:i", $slot["end"]), "time", $s, $s, false, false);
    }
}

if (isset($_POST)&& !empty($_POST)) {
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
        echo json_encode($book);
        // TODO CHANGE USER_ID
        $user_id = 'CCC1CCC1CCC1CCC1';
        UserBookingService::createReservation($user_id, $book["service"], $book["staff"], $book["time"]);
    } 
}

$query = array(
    "staff" => $selected_staff,
    "service" => $selected_service,
    "day" => $selected_day
);
$backlink = "/user/available.php?".http_build_query($query);

$main = breadcrumb(array("Home" => "/", "Indietro" => $backlink)) . str_replace("%RADIOS_SLOT%", $radios_slot, $main);

$main = str_replace("%SELECTED_SERVICE%", $selected_service, $main);
$main = str_replace("%SELECTED_STAFF%", $selected_staff, $main);
$main = str_replace("%SELECTED_DAY%", $selected_day, $main);

$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;
