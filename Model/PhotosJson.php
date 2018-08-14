<?php
namespace AdelineD\OC\P9\Model;

class PhotosJson extends Model {

    //Méthode qui recupere toutes les photos publiques
    public function getAllPhotos(){
        $sql = 'SELECT p.*, m.pseudo, m.idMember 
                FROM members AS m 
                INNER JOIN photos AS p 
                ON memberId = idMember  
                WHERE status=0';
        $photos = $this->executeQuery($sql) or die('Erreur');
        while ($photo = $photos->fetch(\PDO::FETCH_ASSOC))
        {
            $data [] = $photo;
        }
        $photosJson = json_encode($data);
        echo $photosJson;
    }

}