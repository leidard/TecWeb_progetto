<?php
require_once  __DIR__ . '/../components/page.php';
require_once  __DIR__ . '/../components/header.php';
require_once  __DIR__ . '/../components/booked_pending_staff.php';
require_once  __DIR__ . '/../components/breadcrumb.php';

$pagina = page('Prenotazioni');
$header = _header(array("Staff" => "/staff/", "Prenotazioni" => "/staff/prenotazioni.php", "In Attesa di Conferma" => "/staff/pending.php"));
$main = file_get_contents( __DIR__ . '/../../views/staff/pending.html');

require_once __DIR__ . '/../../services/staff/book.php';
require_once __DIR__ . '/../../services/public/staff.php';
require_once __DIR__ . '/../../services/helpers.php';

if (isset($_POST) && !empty($_POST)) {
    $book = array(
        "reservation" => NULL,
        "action" => NULL,
    );
    if (isset($_POST["reservation"]) && preg_match('/^[0-9]+$/', $_POST["reservation"])) {
        $book["reservation"] = $_POST["reservation"];
    } else return;
    if (isset($_POST["action"]) && preg_match('/^(ACCEPT)|(REJECT)$/', $_POST["action"])) {
        $book["action"] = $_POST["action"];
    } else return;


    if ($book["reservation"] !== NULL && $book["action"] !== NULL) {
        if ($book["action"] === "ACCEPT") {
            StaffReservationService::confirm($book["reservation"]);
        }else if ($book["action"] === "REJECT") {
            StaffReservationService::reject($book["reservation"]);
        }
    }
}

$unconf = StaffReservationService::getAllUnconfirmed();
$strunconf = "";
foreach($unconf as $r) {
    $strunconf .= booked_pending_staff($r["_id"], $r["start_at"], $r["end_at"]- $r["start_at"], $r["service"], $r["price"], $r["confirmed"]);
}
$main = str_replace("%UNCONFIRMED%", $strunconf, $main);


$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;
