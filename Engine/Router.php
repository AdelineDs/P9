<?php

use \AdelineD\OC\P9\Controller\ControllerHome;
use \AdelineD\OC\P9\Controller\ControllerError;
use \AdelineD\OC\P9\Controller\ControllerMap;
use \AdelineD\OC\P9\Controller\ControllerPictures;
use \AdelineD\OC\P9\Controller\ControllerPhotosAjax;
use \AdelineD\OC\P9\Controller\ControllerMember;

//class autoloading
require_once 'Autoloader.php';
Autoloader::register();

class Router {
    
    private $ctrlHome;
    private $ctrlError;
    private $ctrlMap;
    private $ctrlPictures;
    private $ctrlPhotosAjax;
    private $ctrlMember;


    public function __construct() {
        $this->ctrlHome = new ControllerHome();
        $this->ctrlMap = new ControllerMap();
        $this->ctrlPictures = new ControllerPictures();
        $this->ctrlPhotosAjax = new ControllerPhotosAjax();
        $this->ctrlMember= new ControllerMember();
        $this->ctrlError = new ControllerError();
    }

    /**
     *
     */
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
                    if (isset($_GET["latMin"])&&isset($_GET["latMax"])&&isset($_GET["lngMin"])&&isset($_GET["lngMax"])&&isset($_GET["photosArray"])) {
                        $latMin = $_GET["latMin"];
                        $latMax = $_GET["latMax"];
                        $lngMin = $_GET["lngMin"];
                        $lngMax = $_GET["lngMax"];
                        $photosArray = $_GET["photosArray"];
                        $this->ctrlPhotosAjax->getAroundPhotos($latMin, $latMax, $lngMin, $lngMax, $photosArray);
                    }
                    else{
                        throw new \Exception( "Données non présentes");
                    }
                }
                elseif ($_GET['action'] == 'member'){
                    $idMember = intval($this->getParam($_GET, 'id'));
                    if ($idMember > 0){
                        $this->ctrlMember->memberPage($idMember);
                    }
                    else{
                        throw new \Exception("Identifiant de membre non valide.");
                    }
                }
                //send comment
                elseif ($_GET['action'] == 'comment'){
                    if(!empty($_POST['author']) && !empty($_POST['comment'])){
                        $author = $this->getParam($_POST, 'author');
                        $comment = $this->getParam($_POST, 'comment');
                        $idMember = $this->getParam($_POST, 'id');
                        $this->ctrlMember->comment($idMember, $author, $comment);
                    }
                    else{
                        throw new \Exception("Tous les champs ne sont pas remplis !");
                    }
                }
                elseif ($_GET['action'] == 'registrationForm'){
                    $this->ctrlMember->viewRegistration();
                }
                elseif ($_GET['action'] == 'registration'){
                    if(!empty($_POST['pseudo']) && !empty($_POST['pass1']) && !empty($_POST['pass2']) && !empty($_POST['email'])){
                        $pseudo = $this->getParam($_POST, 'pseudo');
                        $pass1 = $this->getParam($_POST, 'pass1');
                        $pass2 = $this->getParam($_POST, 'pass2');
                        $email = $this->getParam($_POST, 'email');
                        $this->ctrlMember->registration($pseudo, $pass1, $pass2, $email);
                    }
                    else{
                        $error = "Tous les champs ne sont pas remplis";
                        $this->ctrlMember->viewRegistration($error);
                    }
                }
                elseif ($_GET['action'] == 'connectForm'){
                    $this->ctrlMember->viewConnection();
                }
                elseif ($_GET['action'] == 'connectMember') {
                    if (isset($_POST['pseudo']) && $_POST['pass']) {
                        if (!empty($_POST['pseudo']) && !empty($_POST['pass'])) {
                            $this->ctrlMember->connection($_POST['pseudo'], $_POST['pass']);
                        }
                        else{
                            $error = "Tous les champs ne sont pas remplis";
                            $this->ctrlMember->viewConnection($error);
                        }
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
        $this->ctrlError->error($msgError);
    }
}//--end class Router      

