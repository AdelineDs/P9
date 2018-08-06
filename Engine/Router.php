<?php

use \AdelineD\OC\P9\Controller\ControllerHome;
use \AdelineD\OC\P9\Controller\ControllerRegistration;
use \AdelineD\OC\P9\View\View;

//twig autoload
require_once 'vendor/autoload.php';

//class autoloading
require_once 'Autoloader.php';
Autoloader::register();

class Router {
    
    private $ctrlHome;
    private $ctrlRegistration;



    public function __construct() {
        $this->ctrlHome = new ControllerHome();
        $this->ctrlRegistration = new ControllerRegistration();
    }
    
    public function routerQuery(){
        try{
            if(isset($_GET['action'])){
                if($_GET['action'] == 'registration'){
                    $this->ctrlRegistration->view();
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

