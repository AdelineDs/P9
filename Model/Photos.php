<?php
namespace AdelineD\OC\P9\Model;


class Photos extends Model {

    public function getPopularPhotos(){
        $sql = 'SELECT * FROM photos ORDER BY likes DESC LIMIT 9';
        $photos = $this->executeQuery($sql, array());
        return $photos;
    }

    //Renvoie les photos publiques  présentes dans les limites de la cartes données
    public function getAroundPhotos($latMin, $latMax, $lngMin, $lngMax, $photosArray){
        $sql = 'SELECT * FROM photos WHERE lat > ? && lat < ? && lng > ? && lng < ? && status=0';
        $aroundPhotos = $this->executeQuery($sql, array($latMin, $latMax, $lngMin, $lngMax));
        $array = json_decode($photosArray);
        $data = [];
        //on retire le prefixe pour recupérer l'id de la photo
        foreach($array as $key => $element){
            $array[$key]= str_replace('photo_', '', $element);
        }
        while ($aPhoto = $aroundPhotos->fetch(\PDO::FETCH_ASSOC))
        {
            $data [] = $aPhoto;
        }
        //pour chaque photo de la galerie secondaire si son id est déjà présent dans la galerie principale
        //on retire la photo de la galerie secondaire
        foreach ($data as $photo){
            if (in_array($photo['id'], $array)){
                unset($data[array_search($photo, $data)]);
            }
        }
        return $data;
    }

    //récupère toutes les photos d'un membre
    public function getAllPhotosMember($idMember){
        $sql = 'SELECT * FROM photos WHERE memberId=? AND status=0 ORDER BY likes DESC';
        $photos = $this->executeQuery($sql, array($idMember));
        return $photos;
    }

    //récupère toutes les photos d'un membre
    public function getAllPhotosAndLikes($idMember, $idConnectMember){
        $sql = 'SELECT photos.*, IF(likes.id_photo IS NULL, FALSE, TRUE) as liked 
                FROM photos 
                LEFT JOIN likes 
                ON (likes.id_member = ? AND likes.id_photo = photos.id)
                WHERE photos.memberId = ?
                ORDER BY likes DESC';
        $photos = $this->executeQuery($sql, array($idConnectMember, $idMember));
        return $photos;
    }

    public function addPhoto(){

    }
}
