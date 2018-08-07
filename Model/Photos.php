<?php
namespace AdelineD\OC\P9\Model;


class Photos extends Model {

    public function getPopularPhotos(){
        $sql = 'SELECT * FROM photos WHERE status=0 ORDER BY note DESC LIMIT 9';
        $photos = $this->executeQuery($sql, array());
        return $photos;
    }
}