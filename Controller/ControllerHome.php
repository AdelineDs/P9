<?php
namespace AdelineD\OC\P9\Controller;

use \AdelineD\OC\P9\Model\PhotosManager;

class ControllerHome extends ControllerMain {

    private $photos;

    public function __construct(){
        $this->photos = new PhotosManager();
    }

    //display home page
    public function home(){
        if (isset($_SESSION['id']) && isset($_SESSION['pseudo'])){
            if (!empty($_SESSION['id']) && !empty($_SESSION['pseudo'])){
                $photos = $this->photos->getPopularPhotos();
                $this->render('viewHome.php.twig', array(
                    'photos' => $photos,
                    'session' => $_SESSION
                ));
            }
        }
        else{
            $publicPhotos = $this->photos->getPublicPopularPhotos();
            $this->render('viewHome.php.twig', array(
                'publicPhotos' => $publicPhotos,
                'session' => $_SESSION
            ));

        }
    }

    public function legalNotice(){
        $this->render('viewLegalNotice.php.twig', array());
    }
}

