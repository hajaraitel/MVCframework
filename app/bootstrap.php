<?php
//Load Config
require_once 'config/config.php';

//Autoload core libraries
spl_autoload_register(function($classname){
    require_once 'libraries/'.$classname.'.php';
});
