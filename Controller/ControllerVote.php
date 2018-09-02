<?php
/**
 * Created by PhpStorm.
 * User: decaa
 * Date: 17/08/2018
 * Time: 11:06
 */

namespace AdelineD\OC\P9\Controller;

use \AdelineD\OC\P9\Model\Vote;

/**
 * Class ControllerVote
 * @package AdelineD\OC\P9\Controller
 */
class ControllerVote extends ControllerMain
{
    /**
     * @var Vote
     */
    private $vote;

    /**
     * ControllerVote constructor.
     */
    public function __construct()
    {
        $this->vote = new Vote();
    }

    /**
     * @param $photoId int id of the photo for which a member voted
     * @param $memberId int id of the member who voted
     * @param $likedMemberId int id of the member owning the photo
     * @throws \Exception
     */
    public function vote($photoId, $memberId, $likedMemberId){
        $this->vote->doVote($photoId, $memberId);
        header('Location: index.php?action=member&id='.$likedMemberId);
    }
}