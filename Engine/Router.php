<?php

use \AdelineD\OC\P9\Controller\ControllerHome;
use \AdelineD\OC\P9\Controller\ControllerMap;
use \AdelineD\OC\P9\Controller\ControllerPictures;
use \AdelineD\OC\P9\Controller\ControllerPhotosAjax;

//class autoloading
require_once 'Autoloader.php';
Autoloader::register();

class Router {
    
    private $ctrlHome;
    private $ctrlMap;
    private $ctrlPictures;
    private $ctrlPhotosAjax;


    public function __construct() {
        $this->ctrlHome = new ControllerHome();
        $this->ctrlMap = new ControllerMap();
        $this->ctrlPictures = new ControllerPictures();
        $this->ctrlPhotosAjax = new ControllerPhotosAjax();
    }
    
    public function routerQuery(){
        try{
            if(isset($_GET['action'])){
                if ($_GET['action'] == 'map'){
                    $this->ctrlMap->map();
                }
                elseif ($_GET['action'] == 'getPictures')
                {
                    $this->ctrlPictures->getPictures();
                }
                elseif ($_GET['action'] == 'getAroundPhotos')
                {
                    if (isset($_GET["latMin"])&&isset($_GET["latMax"])&&isset($_GET["lngMin"])&&isset($_GET["lngMax"])) {
                        $latMin = $_GET["latMin"];
                        $latMax = $_GET["latMax"];
                        $lngMin = $_GET["lngMin"];
                        $lngMax = $_GET["lngMax"];
                        $this->ctrlPhotosAjax->getAroundPhotos($latMin, $latMax, $lngMin, $lngMax);
                    }
                    else{
                        throw new \Exception( "Données non présentes");
                    }
                }
                else{
                    throw new \Exception("Action non valide");
                }
            }
            // default action home page
           else{
               $this->ctrlHome->home();
            } 
        }
        catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
    
    private function getParam($array, $name){
        if(isset($array[$name])){
            return $array[$name];
        }else{
            throw new \Exception("Paramètre '$name' absent");
        }
    }

        private function error($msgError){
        $view = new View("Error");
        $view->generate(array('msgError' => $msgError));
}
}//--end class Router      

