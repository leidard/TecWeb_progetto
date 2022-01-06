<?php

function menulink($name, $ref, $current, $lang) {
    if (!$lang) $lang="";
    else $lang = 'lang="el"';
    if ($current)
        $current = 'class="current" aria-current="page"';
    return "<li><a $current $lang href=\"$ref\">$name</a></li>";
}



function _menu(){
    $template = file_get_contents(__DIR__.'/../../views/components/nav_menu.html');
    $out = $template;

    $pagine = array (
        'Home' => '/',
        'Servizi' => '/servizi.php',
        'Staff' => '/staff.php',
        'Galleria' => '/galleria.php',
        'Contatti' => '/contatti.php',
        'Prenota' => '/prenota.php',
        'Accedi' => '/accedi.php',
        'Registrati' => '/registrazione.php'
    );
    
    $langs = array(
        "Home" => "en",
    );

    $current = strtok($_SERVER["REQUEST_URI"], '?');
    $current = str_replace("index.php", "", $current);

    $str = "";
    foreach($pagine as $name => $ref){  
        $str .= menulink($name, $ref, $current == $ref, $langs[$name]);
    }
    
    $out=str_replace("%MENU_ELEMENTS%",$str,$out);

    return $out;
}

?>
