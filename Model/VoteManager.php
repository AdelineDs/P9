<?php
/**
 * Created by PhpStorm.
 * User: decaa
 * Date: 17/08/2018
 * Time: 11:07
 */

namespace AdelineD\OC\P9\Model;


class VoteManager extends Model
{

    public function doVote($photoId, $memberId){
        //checking tha the photo exists
        $photo = $this->searchPhoto($photoId, $memberId);
        if ($photo > 0 ){
            //if the photo exists to check if is already a vote from the user
            $vote = $this->searchVote($photoId, $memberId);
            //if there no vote on this photo for this user, the vote is recorded
            if ($vote == 0){
                $sql = 'INSERT INTO likes(id_photo, id_member) VALUES(?, ?)';
                $this->executeQuery($sql, array($photoId, $memberId));
                $sql_update = 'UPDATE photos SET likes=likes+1 WHERE id=?';
                $this->executeQuery($sql_update, array($photoId));
            }
            //if there is a vote it is erased
            else{
                $sql = 'DELETE FROM likes WHERE id_photo=? AND id_member=?';
                $this->executeQuery($sql, array($photoId, $memberId));
                $sql_update = 'UPDATE photos SET likes=likes-1 WHERE id=?';
                $this->executeQuery($sql_update, array($photoId));
            }
        }
        else{
            throw new \Exception("Identifiant de la photo inconnue, impossible de voter");
        }
    }

    //checking tha the photo exists
    public function searchPhoto($photoId){
        $sql = 'SELECT * FROM photos WHERE id=?';
        $result= $this->executeQuery($sql, array($photoId));
        $result_count = $result->rowCount();
        return $result_count;
    }

    //checking is vote exists
    public function searchVote($photoId, $memberId){
        $sql = 'SELECT * FROM likes WHERE id_photo=? AND id_member=?';
        $result = $this->executeQuery($sql, array($photoId, $memberId));
        $result_count = $result->rowCount();
        return $result_count;
    }

    //delete the vote of a photo
    public function deleteVote($idPhoto){
        $sql = 'DELETE FROM likes WHERE id_photo=?';
        $this->executeQuery($sql, array($idPhoto));
    }
}