<?php
/**
 * Created by PhpStorm.
 * User: decaa
 * Date: 17/08/2018
 * Time: 11:07
 */

namespace AdelineD\OC\P9\Model;


class Vote extends Model
{
    public function doVote($photoId, $memberId){
        //on verifie que la photo existe bien
        $photo = $this->searchPhoto($photoId, $memberId);
        if ($photo > 0 ){
            //si la photo existe bien on verifie s'il existe déjà un vote de  la part de l'utilisateur
            $vote = $this->searchVote($photoId, $memberId);
            //s'il n'existe aucun vote sur cette photo pour cet utilisateur on enregistre le vote
            if ($vote == 0){
                $sql = 'INSERT INTO likes(id_photo, id_member) VALUES(?, ?)';
                $this->executeQuery($sql, array($photoId, $memberId));
                $sql_update = 'UPDATE photos SET likes=likes+1 WHERE id=?';
                $this->executeQuery($sql_update, array($photoId));
            }
            //sinon on efface le vote
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

    public function searchPhoto($photoId){
        $sql = 'SELECT * FROM photos WHERE id=?';
        $result= $this->executeQuery($sql, array($photoId));
        $result_count = $result->rowCount();
        return $result_count;
    }

    public function searchVote($photoId, $memberId){
        $sql = 'SELECT * FROM likes WHERE id_photo=? AND id_member=?';
        $result = $this->executeQuery($sql, array($photoId, $memberId));
        $result_count = $result->rowCount();
        return $result_count;
    }
}