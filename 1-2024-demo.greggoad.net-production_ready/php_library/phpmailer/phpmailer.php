<?php 
    $sd=scandir(__DIR__.'/src');
    
    foreach($sd as $s)
    {
        if(is_file(__DIR__."/src/$s")){
            require_once(__DIR__."/src/$s");
        }
    }
?>