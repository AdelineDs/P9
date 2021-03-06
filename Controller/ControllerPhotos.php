<?php
/**
 * Created by PhpStorm.
 * User: decaa
 * Date: 08/08/2018
 * Time: 18:25
 */

namespace AdelineD\OC\P9\Controller;

use \AdelineD\OC\P9\Model\PhotosManager;
use AdelineD\OC\P9\Model\VoteManager;

class ControllerPhotos extends ControllerMain {

    private $photos;
    private $vote;

    public function __construct()
    {
        $this->photos = new PhotosManager();
        $this->vote = new VoteManager();
    }

    //get photos for the map
    public function getPictures(){
        if (isset($_SESSION['id']) && isset($_SESSION['pseudo'])){
            if (!empty($_SESSION['id']) && !empty($_SESSION['pseudo'])){
                $this->photos->getAllPhotosJson();
            }
        }
        else{
            $this->photos->getAllPublicPhotosJson();
        }
    }

    //get all photo in the bounds of the map
    public function getAroundPhotos($latMin, $latMax, $lngMin, $lngMax, $photosArray){
        $arroundPhotos = $this->photos->getAroundPhotos($latMin, $latMax, $lngMin, $lngMax, $photosArray);
        $this->render('viewAroundPhotos.php.twig', array('aroundPhotos' => $arroundPhotos));
    }

    // display add photo page
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

    //add a photo
    public function addPhoto($idMember, $title, $description, $url, $lat, $lng, $status){
        $this->photos->addPhoto($idMember, $title, $description, $url, $lat, $lng, $status);
        header('Location: index.php?action=member&id='.$idMember);
    }

    // display profil management
    public function viewPhotoEditing($idPhoto, $idMember, $error = null)
    {
        if ($error == null){
            $photo = $this->photos->getPhoto($idPhoto, $idMember);
            $this->render('viewAddPhoto.php.twig', array(
                'photo' => $photo,
                'session' => $_SESSION
            ));
        }
        else{
            $photo = $this->photos->getPhoto($idPhoto, $idMember);
            $this->render('viewAddPhoto.php.twig', array(
                'error' => $error,
                'photo' => $photo,
                'session' => $_SESSION
            ));
        }
    }

    //edit a photo
    public function editPhoto($idMember, $idPhoto, $title, $description, $lat, $lng, $status){
        $this->photos->editPhoto($idPhoto, $title, $description, $lat, $lng, $status);
        header('Location: index.php?action=member&id='.$idMember);
    }

    //display confirmation page for deleting photo
    public function viewConfirmation($idPhoto, $idMember){
        $photo = $this->photos->getPhoto($idPhoto, $idMember);
        $this->render('viewConfirmation.php.twig', array(
            'photo' => $photo,
            'session' => $_SESSION
        ));
    }

    //confirm deleting photo
    public function confirmDeletePhoto($idPhoto, $urlPhoto, $idMember) {
        $this->vote->deleteVote($idPhoto);
        $this->photos->confirmDelete($idPhoto);
        if (file_exists($urlPhoto)){
            unlink($urlPhoto);
        }
        header('Location: index.php?action=member&id='.$idMember);
    }

}