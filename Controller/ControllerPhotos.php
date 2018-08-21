<?php
/**
 * Created by PhpStorm.
 * User: decaa
 * Date: 08/08/2018
 * Time: 18:25
 */

namespace AdelineD\OC\P9\Controller;

use \AdelineD\OC\P9\Model\PhotosJson;
use \AdelineD\OC\P9\Model\Photos;

class ControllerPhotos extends ControllerMain {

    private $photosJson;
    private $photos;

    public function __construct()
    {
        $this->photosJson = new PhotosJson();
        $this->photos = new Photos();
    }

    public function getPictures(){
        $this->photosJson->getAllPhotos();
    }

    // display connect page
    public function viewAddPhoto ($error = null)
    {
        if ($error == null){
            $this->render('viewAddPhoto.php.twig', array('session' => $_SESSION));
        }
        else{
            $this->render('viewAddPhoto.php.twig', array(
                'error' => $error,
                'session' => $_SESSION
                ));
        }
    }

    public function addPhoto($idMember, $title, $description, $url, $lat, $lng, $status){
        $this->photos->addPhoto($idMember, $title, $description, $url, $lat, $lng, $status);
        header('Location: index.php?action=member&id='.$idMember);
    }

}