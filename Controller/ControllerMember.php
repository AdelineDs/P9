<?php
/**
 * Created by PhpStorm.
 * User: decaa
 * Date: 14/08/2018
 * Time: 11:31
 */

namespace AdelineD\OC\P9\Controller;

use \AdelineD\OC\P9\Model\Members;
use \AdelineD\OC\P9\Model\Photos;

class ControllerMember extends ControllerMain
{
    private $member;
    private $photos;

    public function __construct()
    {
        $this->member = new Members();
        $this->photos = new Photos();
    }

    public function memberPage($idMember){
        $member = $this->member->getMember($idMember);
        $photos = $this->photos->getAllPhotosMember($idMember);
        $this->render("viewMember.php.twig", array(
            'member' => $member,
            'photos' => $photos
        ));
    }

}