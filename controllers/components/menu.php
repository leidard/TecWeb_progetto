<?php

function menulink($list, $current) {
    
}

function _menu($current, $list, $logged = false){
    $template = file_get_contents(__DIR__.'/../../views/components/menu.html');
    $out = $template;
    
    $str = "";
    foreach($list as $page){
        if ($page === $current){
            if($page === 'Home')
                $str .= "<li><span class=\"pag_corrente\" lang=\"en\">$page</span></li>";
            else
                $str .= "<li><span class=\"pag_corrente\">$page</span></li>";
        }else{
            $ref = strtolower($page).".php";
            $str .= "<li><a class=\"menu_link\" href=\"$ref\">$page</a></li>";
        }
    }

    if($logged){ //TODO: bisogna gestire che se è loggato la barra è diversa
    }
    
    $out=str_replace("%MENU_ELEMENTS%",$str,$out);

    return $out;
}

?>
