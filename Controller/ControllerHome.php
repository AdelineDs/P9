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
        $photos = $this->photos->getPublicPopularPhotos();
        $this->render('viewHome.php.twig', array(
            'publicPhotos' => $photos,
            'session' => $_SESSION
        ));
    }

    //display home page
    public function homeMembers(){
        $photos = $this->photos->getPopularPhotos();
        $this->render('viewHome.php.twig', array(
            'photos' => $photos,
            'session' => $_SESSION
        ));
    }

    public function legalNotice(){
        $this->render('viewLegalNotice.php.twig', array());
    }
}

