<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/servizio.php';
require_once '../services/public/service.php';

$pagina = page('Listino barba - Scissorhands');
$path = array(
    "Home" => "/",
    "Servizi" => "../servizi.php",
    "Listino per la barba" => "../listino_barba.php",
);
$header = _header('Listino per la barba', $path);

$main = file_get_contents('../views/listino_barba.html');

function listaServizi() {
    $services = PublicServiceService::getAll();
    if (!$services)
        $out = "<p>PROBLEMA CON DATABASE!</p>"; 
    else{
        $out = "";
    
        foreach($services as $service){      
            if ($service["type"] === 'barba')
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