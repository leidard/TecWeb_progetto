<?php

function _breadcrumb($els) {
    // if(empty($path))
    //     return "";
    //$template = file_get_contents(__DIR__.'/../../views/components/breadcrumb.html');

    //$out = $template;
    
    
    // $out = file_get_contents(__DIR__.'/../../views/components/nav_breadcrumb.html');
    // $out = str_replace('%NAVBREADCRUMB%', $template, $out);
    // $breadcrumb = _breadcrumb($path);
    // $out = str_replace("%BREADCRUMB%",$breadcrumb,$out);


    $str = "";
    foreach ($els as $name => $ref) {
        $path = strtok($_SERVER["REQUEST_URI"], '?');
        $path = str_replace("index.php", '', $path);
        if ($ref === $path) { 
            if($name === "Home") 
                $str.= "<span lang=\"en\">$name</span>";
            else
                $str.= "<span>$name</span>";
        } else {
            $str.= "<a href=\"$ref\">$name</a> > ";
        }
    }

    //$out = str_replace("%BREADCRUMB_ELEMENTS%", $str, $out); inutile, da eliminare anche breadcrumb.html probabilmente. oppure va riorganizzato
    
    return $str;
}
