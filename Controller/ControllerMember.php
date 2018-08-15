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
use \AdelineD\OC\P9\Model\Comments;

class ControllerMember extends ControllerMain
{
    private $member;
    private $photos;
    private $comments;

    public function __construct()
    {
        $this->member = new Members();
        $this->photos = new Photos();
        $this->comments = new Comments();
    }

    public function memberPage($idMember){
        $member = $this->member->getMember($idMember);
        $photos = $this->photos->getAllPhotosMember($idMember);
        $comments = $this->comments->getComments($idMember);
        $this->render("viewMember.php.twig", array(
            'member' => $member,
            'photos' => $photos,
            'comments' => $comments
        ));
    }

    // add comment to a member page
    public function comment($idMember, $author, $comment) {
        // save comment
        $this->comments->addComment($idMember, $author, $comment);
        // refresh post
        $this->memberPage($idMember);
    }

}