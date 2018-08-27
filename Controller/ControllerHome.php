<?php
namespace AdelineD\OC\P9\Controller;

use \AdelineD\OC\P9\Model\Photos;

class ControllerHome extends ControllerMain {

    private $photos;

    public function __construct(){
        $this->photos = new Photos();
    }

    //display home page
    public function home(){
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

