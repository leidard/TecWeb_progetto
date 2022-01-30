<?php

function _meta_index(bool $index){
    if($index)
        return $out = "<meta name='keywords' content='%KEYWORDS%' /> \n    <meta name='description' content='%DESCRIPTION%' />";
    else
        return $out = '<meta name="robots" content="noindex"/>';   
}
