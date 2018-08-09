<?php
namespace AdelineD\OC\P9\Model;


class Photos extends Model {

    public function getPopularPhotos(){
        $sql = 'SELECT * FROM photos WHERE status=0 ORDER BY note DESC LIMIT 9';
        $photos = $this->executeQuery($sql, array());
        return $photos;
    }

    //Renvoie les photos publiques  présentes dans les limites données
    public function getAroundPhotos($latMin, $latMax, $lngMin, $lngMax){
        $sql = 'SELECT * FROM photos WHERE lat > ? && lat < ? && lng > ? && lng < ? && status=0';
        $arroundsPhotos = $this->executeQuery($sql, array($latMin, $latMax, $lngMin, $lngMax));
        return $arroundsPhotos;

    }
}