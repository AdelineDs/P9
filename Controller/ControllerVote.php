<?php
/**
 * Created by PhpStorm.
 * User: decaa
 * Date: 17/08/2018
 * Time: 11:06
 */

namespace AdelineD\OC\P9\Controller;

use \AdelineD\OC\P9\Model\Vote;

class ControllerVote extends ControllerMain
{
    private $vote;

    public function __construct()
    {
        $this->vote = new Vote();
    }

    public function vote($photoId, $memberId, $likedMemberId){
        $this->vote->doVote($photoId, $memberId);
        header('Location: index.php?action=member&id='.$likedMemberId);
    }
}