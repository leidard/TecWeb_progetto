<?php
require_once  __DIR__ . '/../components/page.php';
require_once  __DIR__ . '/../components/header.php';
require_once  __DIR__ . '/../components/booked_row_staff.php';
require_once  __DIR__ . '/../components/breadcrumb.php';

if (session_status() === PHP_SESSION_NONE)
	session_start();

if(!isset($_SESSION["sessionid"]))
{
	header("Location: /accedi.php");
	die();
}
if($_SESSION["type"] != "OWNER") #TODO dove mandarlo?
{
	
	header("Location: user/prenotazioni.php");
	die();
}
	
$user_id = $_SESSION["sessionid"];


$pagina = page('Prenotazioni staff - Scissorhands');
$header = _header(array("Prenotazioni" => "/staff/prenotazioni.php",));
$main = file_get_contents(__DIR__ . '/../../views/staff/prenotazioni.html');

require_once __DIR__ . '/../../services/staff/book.php';
require_once __DIR__ . '/../../services/helpers.php';

$today = floorDay(time()) / 86400;
$selected_day = $today;
if (isset($_GET["day"]) && preg_match('/^[0-9]+$/', $_GET["day"])) {
    $selected_day = $_GET["day"];
} else {
    header("Location: /staff/prenotazioni.php?day=$selected_day");
	die();
}

$prev_day = $selected_day - 1;
$next_day = $selected_day + 1;
$prev_week = $selected_day - 7;
$next_week = $selected_day + 7;
$extended_date = "";
switch ($selected_day) {
    case $today:
        $extended_date = "di Oggi";
        break;
    case $today + 1:
        $extended_date = "di Domani";
        break;
    case $today - 1:
        $extended_date = "di Ieri";
        break;
    default:
        $extended_date = "del " . date("d M", $selected_day * 86400);
}

$main = str_replace("%EXTENDED_DATE%", $extended_date, $main);
$main = str_replace("%NOW_DAY%", $today, $main);
$main = str_replace("%PREV_DAY%", $prev_day, $main);
$main = str_replace("%NEXT_DAY%", $next_day, $main);
$main = str_replace("%PREV_WEEK%", $prev_week, $main);
$main = str_replace("%NEXT_WEEK%", $next_week, $main);

// link prenotazioni in attesa di conferma
$count = StaffReservationService::unconfirmedCount();
$str_pend_link = "";
if ($count>0) {
    $str_pend_link = '<a href="/staff/pending.php">Visualizza '.$count.' prenotazioni in attesa</a>';
}
$main = str_replace("%PENDING_REQ_LINK%", $str_pend_link, $main);


// prenotazioni confermate
$resv = StaffReservationService::getPlannedForDay($selected_day);
$str = "";
foreach ($resv as $r) {
    $str .= booked_row_staff($r["_id"], $r["start_at"], $r["end_at"], $r["service"], $r["staff"], $r["customer_name"] . " " . $r["customer_surname"]);
}
$main = str_replace("%CONFIRMED%", $str, $main);


$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;
