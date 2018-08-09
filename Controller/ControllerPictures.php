<?php
/**
 * Created by PhpStorm.
 * User: decaa
 * Date: 08/08/2018
 * Time: 18:25
 */

namespace AdelineD\OC\P9\Controller;

use AdelineD\OC\P9\Model\PhotosJson;

class ControllerPictures extends ControllerMain {

    private $photos;

    public function __construct()
    {
        $this->photos = new PhotosJson();
    }

    public function getPictures(){
        $this->photos->getAllPhotos();
    }

}