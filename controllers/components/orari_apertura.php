<?php
require_once '../services/public/company.php';
require_once '../services/helpers.php';

function orariApertura(){
    $out = file_get_contents(__DIR__.'/../../views/components/orari_apertura.html');
    $company = PublicCompanyService::get();
    $orarioApertura = gmdate('H:i', $company["open_at"]);
    $orarioChiusura = gmdate('H:i', $company["close_at"]);
    $days = parseDaysSet($company["days"]);
    foreach($days as $day => $isopen)  {            
        if($isopen)
            $out = str_replace("%DAY_$day%", "$orarioApertura-$orarioChiusura", $out);
        else
            $out = str_replace("%DAY_$day%", "CHIUSO", $out);
    }    
    return $out;
}