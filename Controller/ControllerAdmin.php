<?php
/**
 * Created by PhpStorm.
 * User: decaa
 * Date: 21/08/2018
 * Time: 14:19
 */

namespace AdelineD\OC\P9\Controller;

use \AdelineD\OC\P9\Model\Comments;
use \AdelineD\OC\P9\Model\Members;

class ControllerAdmin extends ControllerMain
{
    private $comments;
    private $members;

    public function __construct()
    {
        $this->comments = new Comments();
        $this->members = new  Members();
    }

    //display comments admin page
    public function viewComManagement($error = null){
        $reportedCom = $this->comments->getReportedCom();
        if ($error == null){
            $this->render('viewComAdmin.php.twig', array(
                'reportedCom' => $reportedCom,
                'session' => $_SESSION
            ));
        }
        else{
            $this->render('viewComAdmin.php.twig', array(
                'reportedCom' => $reportedCom,
                'error' => $error,
                'session' => $_SESSION
            ));
        }
    }

    //display form for moderation of comment
    public function moderationForm($idCom){
        $com = $this->comments->getComment($idCom);
        $this->render('viewModerationComForm.php.twig', array(
            'com' => $com,
            'session' => $_SESSION
        ));
    }

    //confirm the moderation of a comment
    public function moderateCom($idCom, $author, $comment){
        $this->comments->modifyCom($idCom, $author, $comment);
        header('Location: index.php?action=comManagement');
    }

    //display confirmation page for deleting comment
    public function viewComConfirmation($idCom){
        $com = $this->comments->getComment($idCom);
        $this->render('viewConfirmation.php.twig', array(
            'com' => $com,
            'session' => $_SESSION
        ));
    }

    //confirm deleting comment
    public function confirmDeleteCom($idCom) {
        $this->comments->confirmDelete($idCom);
        header('Location: index.php?action=comManagement');
    }

    //display confirmation page for deleting member
    public function viewMemberConfirmation($idMember){
        $member = $this->members->getMember($idMember);
        $this->render('viewConfirmation.php.twig', array(
            'member' => $member,
            'session' => $_SESSION
        ));
    }

    //display comments admin page
    public function viewMembersManagement($error = null){
        $members = $this->members->getMembersInfo();
        if ($error == null){
            $this->render('viewMembersAdmin.php.twig', array(
                'members' => $members,
                'session' => $_SESSION
            ));
        }
        else{
            $this->render('viewMembersAdmin.php.twig', array(
                'members' => $members,
                'error' => $error,
                'session' => $_SESSION
            ));
        }
    }
}