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

}