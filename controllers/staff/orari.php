<?php
require_once  __DIR__ . '/../components/page.php';
require_once  __DIR__ . '/../components/header.php';
require_once  __DIR__ . '/../components/booked_row_staff.php';
require_once  __DIR__ . '/../components/breadcrumb.php';
require_once __DIR__ . '/../components/meta_index.php';
require_once __DIR__ . '/../../services/staff/company.php';
require_once __DIR__ . '/../../services/helpers.php';

if (session_status() === PHP_SESSION_NONE)
    session_start();

if (!isset($_SESSION["sessionid"])) {
    header("Location: /accedi.php");
    die();
}
if ($_SESSION["type"] != "OWNER") 
{
    header("Location: /user/prenotazioni.php");
    die();
}

$user_id = $_SESSION["sessionid"];

$pagina = page('Orari - Scissorhands');

$meta_index = _meta_index(false);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$header = _header(array("Orari" => "/staff/orari.php",));
$main = file_get_contents(__DIR__ . '/../../views/staff/orari.html');

if (isset($_POST) && !empty($_POST)) {
    $days = [
        isset($_POST['day-0']),
        isset($_POST['day-1']),
        isset($_POST['day-2']),
        isset($_POST['day-3']),
        isset($_POST['day-4']),
        isset($_POST['day-5']),
        isset($_POST['day-6'])
    ];
    $open_at = null;
    if (isset($_POST["open_at"]) && preg_match('/^[0-9]{1,2}$/', $_POST["open_at"]) && $_POST["open_at"] >= 0 && $_POST["open_at"] <= 23) {
        $open_at = $_POST["open_at"];
    }

    $close_at = null;
    if (isset($_POST["close_at"]) && preg_match('/^[0-9]{1,2}$/', $_POST["close_at"]) && $_POST["close_at"] >= 0 && $_POST["close_at"] <= 23 && $_POST["close_at"] > $_POST["open_at"]) {
        $close_at = $_POST["close_at"];
    }

    StaffCompanyService::update($open_at*3600, $close_at*3600, $days);
	$_SESSION["omessage"] = "<em><span role=\"alert\" id=\"orari-changed\">Orario aggiornato</span></em>";
}

$company = StaffCompanyService::get();

$days = parseDaysSet($company["days"]);

$main = str_replace("%DAY_0%", $days[0] ? "checked" : "", $main);
$main = str_replace("%DAY_1%", $days[1] ? "checked" : "", $main);
$main = str_replace("%DAY_2%", $days[2] ? "checked" : "", $main);
$main = str_replace("%DAY_3%", $days[3] ? "checked" : "", $main);
$main = str_replace("%DAY_4%", $days[4] ? "checked" : "", $main);
$main = str_replace("%DAY_5%", $days[5] ? "checked" : "", $main);
$main = str_replace("%DAY_6%", $days[6] ? "checked" : "", $main);

$main = str_replace("%OPEN_HOUR%", floor($company["open_at"] / 3600), $main);
$main = str_replace("%CLOSE_HOUR%", floor($company["close_at"] / 3600), $main);

if (isset($_POST) && !empty($_POST) && isset($_SESSION["omessage"])) {
	$main = str_replace("%MESSAGGIO%", $_SESSION["omessage"], $main);	
}
else
{
	$main = str_replace("%MESSAGGIO%","", $main);
}

$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;