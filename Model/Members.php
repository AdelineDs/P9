<?php
/**
 * Created by PhpStorm.
 * User: decaa
 * Date: 14/08/2018
 * Time: 11:24
 */

namespace AdelineD\OC\P9\Model;


class Members extends Model
{
    //get member informations
    public function getMember($idMember){
        $sql = 'SELECT idMember, pseudo, DATE_FORMAT(registration_date, \'%d/%m/%Y\') AS registration_date_fr FROM members WHERE idMember=?';
        $member = $this->executeQuery($sql, array($idMember));
        if ($member->rowCount() == 1) {
            return $member->fetch(); // Access to the first result line
        }
        else {
            throw new \Exception("Aucun membre ne correspond à l'identifiant '$idMember'");
        }
    }
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
        $sql = 'SELECT idMember, password FROM members WHERE pseudo= ? ';
        $member = $this->executeQuery($sql, array($pseudo));
        return $member->fetch();
    }

}