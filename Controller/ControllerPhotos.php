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
        if (isset($_SESSION['id']) && isset($_SESSION['pseudo'])){
            if (!empty($_SESSION['id']) && !empty($_SESSION['pseudo'])){
                $this->photosJson->getAllPhotos();
            }
        }
        else{
            $this->photosJson->getAllPublicPhotos();
        }

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
                'session' => $_SESSION,
                'post' => $_POST
                ));
        }
    }

    public function addPhoto($idMember, $title, $description, $url, $lat, $lng, $status){
        $this->photos->addPhoto($idMember, $title, $description, $url, $lat, $lng, $status);
        header('Location: index.php?action=member&id='.$idMember);
    }

}