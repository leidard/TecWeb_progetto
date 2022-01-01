<?php
require_once '../services/public/company.php';

function orariApertura(){
    $orarioApertura = 0;
    $orarioChiusura = 0;
    $out = "";
    $company = PublicCompanyService::get();
    if (!$company)
        $out = "<p>PROBLEMA CON DATABASE!!</p>"; //Sistemare
    else{
        $open_at  = $company["open_at"];
        $orarioApertura = gmdate('H:i', $open_at);
        $close_at = $company["close_at"];
        $orarioChiusura = gmdate('H:i', $close_at);
        $days = PublicCompanyService::parseDaysSet($company["days"]);
        $out=file_get_contents(__DIR__.'/../../views/components/orariApertura.html');
        $giorni = PublicCompanyService::ARRDAY;
        foreach($days as $key => $day)
        {            
            if($day)
                $out = str_replace('%'. $giorni[$key] .'%', $orarioApertura."/ ".$orarioChiusura, $out);
            else
                $out = str_replace('%'. $giorni[$key] .'%', "CHIUSO", $out);
        }    
    }
    return $out;
}