<?php

class Autoloader {
    
    public static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }
    
    public static function autoload($class){
        //list the different folders where to look for the class to load
        $directory = array('Model/', 'Controller/', 'View/');
        //"cleaning" the class name to escape namespace
        $class = str_replace('AdelineD\OC\P9\Controller\\', '', $class);
        $class = str_replace('AdelineD\OC\P9\Model\\', '', $class);
        $class = str_replace('AdelineD\OC\P9\View\\', '', $class);
        $class = str_replace('\\', '/', $class);
        //loop that does the search in different folders
        foreach ($directory as $current_dir){
            $file = $current_dir . $class . '.php';
            if(file_exists($file)){
                require_once $file;
                return;
            }
        }
    }
}