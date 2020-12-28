<?php

function __load_all_classes(){
    foreach (@scandir("App") as $folders){
        if ($folders != "." and $folders != ".." and $folders != "Autoloader.php"){
            foreach (@scandir("App/{$folders}") as $file){
                if ($file != "." and $file != "..") {
                    __load_class("App/{$folders}/{$file}");
                }
            }
        }
    }
}

/**
 * @param string $class
 */
function __load_class(string $class){
    require_once $class;
}
