<?php
namespace AdelineD\OC\P9\Controller;

use AdelineD\OC\P9\Model\Photos;

class ControllerPhotosAjax extends ControllerMain {
    private $photos;

    public function __construct(){
        $this->photos = new Photos();
    }

    //Renvoie les photos présentes dans les limites données
    public function getAroundPhotos($latMin, $latMax, $lngMin, $lngMax, $photosArray){
        $arroundPhotos = $this->photos->getAroundPhotos($latMin, $latMax, $lngMin, $lngMax, $photosArray);
        $this->render('viewAroundPhotos.php.twig', array('aroundPhotos' => $arroundPhotos));
    }
}