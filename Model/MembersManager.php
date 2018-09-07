<?php
/**
 * Created by PhpStorm.
 * User: decaa
 * Date: 14/08/2018
 * Time: 11:24
 */

namespace AdelineD\OC\P9\Model;


class MembersManager extends Model
{
    //get member informations
    public function getMember($idMember){
        $sql = 'SELECT idMember, pseudo, place, avatar_url, reported, DATE_FORMAT(registration_date, \'%d/%m/%Y\') AS registration_date_fr FROM members WHERE idMember=?';
        $member = $this->executeQuery($sql, array($idMember));
        if ($member->rowCount() == 1) {
            return $member->fetch(); // Access to the first result line
        }
        else {
            throw new \Exception("Aucun membre ne correspond à l'identifiant '$idMember'");
        }
    }
    //checking in database the existence of a pseudo or email
    public function verifyMember($pseudo, $email){
        $sql = 'SELECT COUNT(*) FROM members WHERE pseudo=? OR email=?';
        $data = $this->executeQuery($sql, array($pseudo, $email));
        $result = $data->fetchColumn();
        if ($result == 0){
            return true;
        }
    }

    // add new member in bdd
    public function addMember($pseudo, $pass, $email){
        $sql = 'INSERT INTO members(pseudo, password, email, registration_date) VALUES(?, ?, ?, CURRENT_DATE )';
        $this->executeQuery($sql, array($pseudo, $pass, $email));
        $idNewMember = $this->getLastId();
        return $idNewMember;
    }

    //get member account
    public function getMemberConnection($pseudo) {
        $sql = 'SELECT idMember, password, statusMember FROM members WHERE pseudo= ? ';
        $member = $this->executeQuery($sql, array($pseudo));
        return $member->fetch();
    }

    //get all members info
    public function getMembersInfo(){
        $sql = 'SELECT m.idMember, m.pseudo, m.reported, DATE_FORMAT(m.registration_date, \'%d/%m/%Y\') AS registration_date_fr, COUNT(p.id) AS nbPhotos, SUM(p.likes) AS nbLikes
                FROM members AS m 
                LEFT JOIN photos AS p 
                ON m.idMember = p.memberId 
                GROUP BY m.idMember';
        $members = $this->executeQuery($sql);
        return $members;
    }

    //get a member info
    public function getMemberInfo($idMember){
        $sql = 'SELECT m.idMember, m.pseudo, m.reported, DATE_FORMAT(m.registration_date, \'%d/%m/%Y\') AS registration_date_fr, COUNT(p.id) AS nbPhotos, SUM(p.likes) AS nbLikes
                FROM members AS m 
                INNER JOIN photos AS p 
                ON m.idMember = p.memberId 
                WHERE m.idMember=?';
        $member = $this->executeQuery($sql, array($idMember));
        if ($member->rowCount() == 1) {
            return $member->fetch();
        }  //access to the first line of results
        else {
            throw new \Exception("Aucun membre ne correspond à l'identifiant '$idMember'");
        }
    }

    //update a member when is reported
    public function reportMember($memberId){
        $sql = 'UPDATE members SET reported=reported+1  WHERE idMember=?';
        $this->executeQuery($sql, array($memberId));
    }

    //delete a member in database
    public function confirmDelete($idMember) {
        $sql = 'DELETE FROM members WHERE idMember= ?';
        $this->executeQuery($sql, array($idMember));
    }

    //update avatar of a member in database
    public function updateAvatar($idMember, $url){
        $sql = 'UPDATE members SET avatar_url=? WHERE idMember=?';
        $this->executeQuery($sql, array($url, $idMember));
    }

    //update place of a member in database
    public function updatePlace($idMember, $place){
        $sql = 'UPDATE members SET place=? WHERE idMember=?';
        $this->executeQuery($sql, array($place, $idMember));
    }

}