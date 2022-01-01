<?php
function _menu($currentPage, $logged = false){
    $template = file_get_contents(__DIR__.'/../../views/components/menu.html');
    $out = $template;
    $tagPagine = array (
        'Home' => '<a class="menu_link" xml:lang="en" href="index.php">Home</a>',
        'Servizi' => '<a class="menu_link" href="servizi.php">Servizi</a>',
        'Staff' => '<a class="menu_link" href="lo_staff.php">Staff</a>',
        'Galleria' => '<a class="menu_link" href="galleria.php">Galleria</a>',
        'Contatti' => '<a class="menu_link" href="contatti.php">Contatti</a>',
        'Prenota' => '<a class="menu_link" href="prenota.php">Prenota</a>',
        'Login' => '<a class="menu_link" xml:lang="en" href="login.php">Login</a>'
    );

    $str = "";
    foreach ($tagPagine as $name => $ref) {
        if ($currentPage === $name){
            if($name === 'Home')
                $str.= "<li><span class=\"pag_corrente\" xml:lang=\"en\">$name</span></li>";
            else
                $str.= "<li><span class=\"pag_corrente\">$name</span></li>";
        }else{
            $str.= "<li>$ref</li>";
        }
    }

    if($logged){ //TODO: bisogna gestire che se è loggato la barra è diversa
    }
    
    $out=str_replace("%MENU_ELEMENTS%",$str,$out);

    return $out;
}

?>
