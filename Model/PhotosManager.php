<?php
namespace AdelineD\OC\P9\Model;


class PhotosManager extends Model {

    //get all photos
    public function getAllPhotosJson(){
        $sql = 'SELECT p.*, m.pseudo, m.idMember 
                FROM members AS m 
                INNER JOIN photos AS p 
                ON memberId = idMember';
        $photos = $this->executeQuery($sql);
        while ($photo = $photos->fetch(\PDO::FETCH_ASSOC))
        {
            $data [] = $photo;
        }
        $photosJson = json_encode($data);
        echo $photosJson;
    }

    //get all public photos
    public function getAllPublicPhotosJson(){
        $sql = 'SELECT p.*, m.pseudo, m.idMember 
                FROM members AS m 
                INNER JOIN photos AS p 
                ON memberId = idMember
                WHERE status=0';
        $photos = $this->executeQuery($sql);
        while ($photo = $photos->fetch(\PDO::FETCH_ASSOC))
        {
            $data [] = $photo;
        }
        $photosJson = json_encode($data);
        echo $photosJson;
    }

    //get the most popular public photos
    public function getPublicPopularPhotos(){
        $sql = 'SELECT p.*, m.pseudo, m.idMember 
                FROM members AS m 
                INNER JOIN photos AS p 
                ON memberId = idMember
                WHERE status=0
                ORDER BY likes DESC LIMIT 9';
        $photos = $this->executeQuery($sql, array());
        return $photos;
    }

    //get the mst popular photos
    public function getPopularPhotos(){
        $sql = 'SELECT p.*, m.pseudo, m.idMember 
                FROM members AS m 
                INNER JOIN photos AS p 
                ON memberId = idMember
                ORDER BY likes DESC LIMIT 9';
        $photos = $this->executeQuery($sql, array());
        return $photos;
    }

    //get public photos in bounds of the map
    public function getAroundPhotos($latMin, $latMax, $lngMin, $lngMax, $photosArray){
        $sql = 'SELECT * FROM photos WHERE lat > ? && lat < ? && lng > ? && lng < ? && status=0';
        $aroundPhotos = $this->executeQuery($sql, array($latMin, $latMax, $lngMin, $lngMax));
        $array = json_decode($photosArray);
        $data = [];
        //retain the prefix to retrieve the id of the photo
        foreach($array as $key => $element){
            $array[$key]= str_replace('photo_', '', $element);
        }
        while ($aPhoto = $aroundPhotos->fetch(\PDO::FETCH_ASSOC))
        {
            $data [] = $aPhoto;
        }
        /*for each photo of the secondary gallery if is id already present in the
        main gallery we remove the photo of the secondary gallery*/
        foreach ($data as $photo){
            if (in_array($photo['id'], $array)){
                unset($data[array_search($photo, $data)]);
            }
        }
        return $data;
    }

    //get all public photos of a member
    public function getAllPhotosMember($idMember){
        $sql = 'SELECT * FROM photos WHERE memberId=? AND status=0 ORDER BY likes DESC';
        $photos = $this->executeQuery($sql, array($idMember));
        return $photos;
    }

    //get all photos and likes og a member
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

    //add a photo in database
    public function addPhoto($idMember, $title, $description, $url, $lat, $lng, $status){
        $sql = 'INSERT INTO photos(memberId, name, description, url, lat, lng, status, date_added) VALUES(?, ?, ?, ?, ?, ?, ?, NOW())';
        $this->executeQuery($sql, array($idMember, $title, $description, $url, $lat, $lng, $status));
    }

    // get a photo
    public function getPhoto($idPhoto, $idMember){
        $sql = 'SELECT id, memberId, name, description, url, lat, lng, status FROM photos WHERE id=? AND memberID=?';
        $photo = $this->executeQuery($sql, array($idPhoto, $idMember));
        if ($photo->rowCount() == 1) {
            return $photo->fetch(); // Access to the first result line
        }
        else {
            throw new \Exception("Aucune photo ne correspond à l'identifiant '$idPhoto' ou Vous n'êtes pas propriétaire de cette photo");
        }
    }

    //update a photo after editing
    public function editPhoto($idPhoto, $title, $description, $lat, $lng, $status){
        $sql = 'UPDATE photos SET name=?, description=?, lat=?, lng=?, status=? WHERE id=?';
        $this->executeQuery($sql, array($title, $description, $lat, $lng, $status, $idPhoto));
    }

    //delete a photo in database
    public function confirmDelete($idPhoto) {
        $sql = 'DELETE FROM photos WHERE id= ?';
        $this->executeQuery($sql, array($idPhoto));
    }
}
