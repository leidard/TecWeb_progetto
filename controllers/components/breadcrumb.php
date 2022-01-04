<?php

function _breadcrumb($els) {
    //$template = file_get_contents(__DIR__.'/../../views/components/breadcrumb.html');

   //$out = $template;
    $str = "";
    foreach ($els as $name => $ref) {
        if ($ref === strtok($_SERVER["REQUEST_URI"], '?')){ 
            if($name === "Home") 
                $str.= "<span lang=\"en\">$name</span>";
            else
                $str.= "<span>$name</span>";
        }else {
            $str.= "<a href=\"$ref\">$name</a> > ";
        }
    }

    //$out = str_replace("%BREADCRUMB_ELEMENTS%", $str, $out); inutile, da eliminare anche breadcrumb.html probabilmente. oppure va riorganizzato
    
    return $str;
}
