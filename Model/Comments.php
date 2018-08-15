<?php
/**
 * Created by PhpStorm.
 * User: decaa
 * Date: 14/08/2018
 * Time: 16:59
 */

namespace AdelineD\OC\P9\Model;


class Comments extends Model{

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
}
