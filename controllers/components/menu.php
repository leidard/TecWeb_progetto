<?php

function menulink($name, $ref, $current, $lang) {
    if (!$lang) $lang="";
    else $lang = 'lang="el"';
    $current_li = 'class=""';
    if ($current) {
        $current = 'aria-current="page"';
        $current_li = 'class="current"';
    }
        
    return "<li $current_li><a $current $lang href=\"$ref\">$name</a></li>";
}

function _menu($sess_type = "GUEST"){
    $template = file_get_contents(__DIR__.'/../../views/components/nav_menu.html');
    $out = $template;

    $pagine = array(
        "OWNER" => array (
            'Home' => '/',
            'Servizi' => '/servizi.php',
            'Staff' => '/staff.php',
            'Galleria' => '/galleria.php',
            'Contatti' => '/contatti.php',
            'Prenotazioni' => '/staff/prenotazioni.php',
            'Esci' => '/logout.php'
        ),
        "USER" => array (
            'Home' => '/',
            'Servizi' => '/servizi.php',
            'Staff' => '/staff.php',
            'Galleria' => '/galleria.php',
            'Contatti' => '/contatti.php',
            'Prenotazioni' => '/user/prenotazioni.php',
            'Profilo' => '/profilo.php',
            'Esci' => '/logout.php',
        ),
        "GUEST" => array (
            'Home' => '/',
            'Servizi' => '/servizi.php',
            'Staff' => '/staff.php',
            'Galleria' => '/galleria.php',
            'Contatti' => '/contatti.php',
            'Prenota' => '/prenota.php',
            'Accedi' => '/accedi.php',
            'Registrati' => '/registrati.php'
        )
    );


    
    $langs = array(
        "Home" => "en",
    );

    $current = strtok($_SERVER["REQUEST_URI"], '?');
    $current = str_replace("index.php", "", $current);

    $str = "";
    foreach($pagine[$sess_type] as $name => $ref){  
        $str .= menulink($name, $ref, $current == $ref, $langs[$name] ?? false);
    }
    
    $out=str_replace("%MENU_ELEMENTS%",$str,$out);

    return $out;
}

?>
