<?php
require_once '../services/public/company.php';

function orariApertura(){
    $days = "";
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
        $days = $company["days"];
    }

    $out .= stampaOrari($days, $orarioApertura, $orarioChiusura);

    return $out;
}

function stampaOrari($days, $orarioApertura, $orarioChiusura){
    $out = "Orari di apertura:<ul>";
    $giorniSettimana = array(
        "MON" => "Lunedì",
        "TUE" => "Martedì",
        "WED" => "Mercoledì",
        "THU" => "Giovedì",
        "FRI" => "Venerdì",
        "SAT" => "Sabato",
        "SUN" => "Domenica"
    );
    foreach($giorniSettimana as $key => $day){
        $out .= "<li>".$day.": ";
        if(str_contains($days, $key))
            $out .=$orarioApertura. "/ " . $orarioChiusura;
        else
            $out .= "CHIUSO";
    $out .="</li>";
    }
    $out .= "</ul>";
    return $out;
}
