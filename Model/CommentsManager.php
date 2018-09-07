<?php
/**
 * Created by PhpStorm.
 * User: decaa
 * Date: 14/08/2018
 * Time: 16:59
 */

namespace AdelineD\OC\P9\Model;


class CommentsManager extends Model{

    // insert new comment in bdd
    public function addComment($idMember, $author, $comment){
        $sql = 'INSERT INTO comments(member_id, author, comment, comment_date) VALUES(?, ?, ?, ?)';
        $date = date(DATE_W3C);
        $this->executeQuery($sql, array($idMember, $author, $comment, $date));
    }

    // return all comment of a member page
    public function getComments($idMember) {
        $sql = 'SELECT id, member_id, author, comment, reported, DATE_FORMAT'
            . '(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM '
            . 'comments WHERE member_id= ? ORDER BY comment_date DESC';
        $comments = $this->executeQuery($sql,array($idMember));
        return $comments;
    }

    //update a comment when is reported
    public function reportCom($idCom){
        $sql = 'UPDATE comments SET reported=1  WHERE id=?';
        $this->executeQuery($sql, array($idCom));
    }

    // return all reported comment
    public function getReportedCom() {
        $sql = 'SELECT comments.*, members.idMember, members.pseudo FROM members INNER JOIN comments ON comments.member_id=members.idMember WHERE comments.reported=1';
        $comments = $this->executeQuery($sql);
        if($comments->rowCount() != 0){
            return $comments;
        }
        else{
            $message = "Aucun commentaire à modérer pour le moment";
            return $message;
        }
    }

    //return a comment
    public function getComment($idCom) {
        $sql = 'SELECT id, member_id, author, comment, DATE_FORMAT'
            . '(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM '
            . 'comments WHERE id= ? ';
        $comment= $this->executeQuery($sql, array($idCom));
        if ($comment->rowCount() == 1) {
            return $comment->fetch();
        }  //access to the first line of results
        else {
            throw new \Exception("Aucun commentaire ne correspond à l'identifiant '$idCom'");
        }
    }

    //update the database after a comment moderation
    public function modifyCom($idCom, $author, $comment){
        $sql = 'UPDATE comments SET author= ?, comment=?, reported=2 WHERE id=?';
        $this->executeQuery($sql, array($author, $comment, $idCom));
    }

    //delete a comment in database
    public function confirmDelete($idCom) {
        $sql = 'DELETE FROM comments WHERE id= ?';
        $this->executeQuery($sql, array($idCom));
    }
}
