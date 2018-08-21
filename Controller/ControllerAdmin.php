<?php
/**
 * Created by PhpStorm.
 * User: decaa
 * Date: 21/08/2018
 * Time: 14:19
 */

namespace AdelineD\OC\P9\Controller;

use \AdelineD\OC\P9\Model\Comments;

class ControllerAdmin extends ControllerMain
{
    private $comments;

    public function __construct()
    {
        $this->comments = new Comments();
    }

    public function viewAdmin($error = null){
        $reportedCom = $this->comments->getReportedCom();
        if ($error == null){
            $this->render('viewAdmin.php.twig', array(
                'reportedCom' => $reportedCom,
                'session' => $_SESSION
            ));
        }
        else{
            $this->render('viewAdmin.php.twig', array(
                'reportedCom' => $reportedCom,
                'error' => $error,
                'session' => $_SESSION
            ));
        }

    }

    public function moderationForm($idCom){
        $com = $this->comments->getComment($idCom);
        $this->render('viewModerationComForm.php.twig', array(
            'com' => $com,
            'session' => $_SESSION
        ));
    }

    public function moderateCom($idCom, $author, $comment){
        $this->comments->modifyCom($idCom, $author, $comment);
        header('Location: index.php?action=management');
    }
}