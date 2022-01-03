<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/servizio.php';
require_once '../services/public/service.php';

$pagina = page('Listino capelli - Scissorhands');
$path = array(
    "Home" => "/",
    "Servizi" => "/servizi.php",
    "Listino per i capelli" => "/listino_capelli.php",
);
$header = _header('Listino per i capelli', $path);

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

$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;