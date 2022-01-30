<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/servizio.php';
require_once '../services/public/service.php';

$pagina = page('Listino capelli - Scissorhands');
$path = array(
    "Servizi" => "/servizi.php",
    "Listino per i capelli" => "/listino_capelli.php",
);
$header = _header($path);

$main = file_get_contents('../views/listino_capelli.html');

function listaServizi() {
    $services = PublicServiceService::getAll();
    if (!$services)
        $out = "<p>PROBLEMA CON DATABASE!</p>"; 
    else{
        $out = "";
    
        foreach($services as $service){      
            if ($service["type"] === 'capelli') 
                $out .= _servizio($service["name"],$service["price"],$service["duration"],$service["description"]);  
        }    
    }    
    
    return $out;
}

$listaServizi = listaServizi();
$main = str_replace('%LISTA_SERVIZI%' , $listaServizi, $main);

$pagina = str_replace('%DESCRIPTION%', "Listino prezzi dei servizi per i capelli di Scissorhands." ,$pagina);
$pagina = str_replace('%KEYWORDS%', "listino, prezzi, servizi, capelli, taglio, tinta, lavaggio, piega, trattamento, barbiere",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;