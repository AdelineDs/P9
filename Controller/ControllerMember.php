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

    //display a member page
    public function memberPage($idMember, $idConnectMember = null){
        if ($idConnectMember == null){
            $member = $this->member->getMember($idMember);
            $photos = $this->photos->getAllPhotosMember($idMember);
            $comments = $this->comments->getComments($idMember);
            $this->render("viewMember.php.twig", array(
                'member' => $member,
                'photos' => $photos,
                'comments' => $comments,
                'session' => $_SESSION,
                'get' => $_GET
            ));
        }
        else{
            $member = $this->member->getMember($idMember);
            $photos = $this->photos->getAllPhotosAndLikes($idMember, $idConnectMember);
            $comments = $this->comments->getComments($idMember);
            $this->render("viewMember.php.twig", array(
                'member' => $member,
                'photos' => $photos,
                'comments' => $comments,
                'session' => $_SESSION,
                'get' => $_GET
            ));
        }

    }

    // add comment to a member page
    public function comment($idMember, $author, $comment) {
        // save comment
        $this->comments->addComment($idMember, $author, $comment);
        // refresh post
        $this->memberPage($idMember);
    }

    //display Registration page
    public function viewRegistration($error = null)
    {
        if ($error == null){
            $this->render('viewRegistrationForm.php.twig', array());
        }
        else{
            $this->render('viewRegistrationForm.php.twig', array('error' => $error, 'post' => $_POST));
        }

    }

    //do registration and display member page
    public function registration($pseudo, $pass1, $pass2, $email){
        $pseudo = strip_tags($pseudo);
        //check format pseudo
        if (preg_match("/^[0-9a-zA-Z]+$/", $pseudo)){
            //check format email
            if ( preg_match ( "/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/" , $email ) )
            {
                //check format password
                if (preg_match("/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/", $pass1)){
                    if ($pass1 == $pass2){
                        $pass_hash = password_hash($pass1, PASSWORD_DEFAULT);
                        $result = $this->member->verifyMember($pseudo,$email);
                        if ($result == true)
                        {
                            $idNewMember = $this->member->addMember($pseudo, $pass_hash, $email);
                            $_SESSION['id'] = $idNewMember;
                            $_SESSION['pseudo'] = $pseudo;
                            header('Location: index.php?action=member&id='.$idNewMember);
                        }
                        else{
                            $insert_error = "Le pseudo ou l'adresse mail a déjà été utilisé.";
                            $this->viewRegistration($insert_error);
                        }
                    }
                    else{
                        $insert_error = "Les mots de passes ne sont pas identiques";
                        $this->viewRegistration($insert_error);
                    }
                }else{
                    $insert_error = "Le format du mot de passe est incorrect : 8 caractères avec au moins 1 chiffre et 1 caractère spécial.";
                    $this->viewRegistration($insert_error);
                }
            }
            else{
                $insert_error = "L'adresse email n'a pas un format valide";
                $this->viewRegistration($insert_error);
            }
        }
        else{
            $insert_error = "Le pseudo n'a pas le format attendu (uniquement lettres et chiffres).";
            $this->viewRegistration($insert_error);
        }
    }

    // display connect page
    public function viewConnection($error = null)
    {
        if ($error == null){
            $this->render('viewConnectForm.php.twig', array());
        }
        else{
            $this->render('viewConnectForm.php.twig', array('error' => $error));
        }
    }

    //member connection
    public function connection($pseudo, $pass){
        $pseudo = strip_tags($pseudo);
        $member = $this->member->getMemberConnection($pseudo);
        $isPassCorrect = password_verify($pass, $member['password']);
        if (!$isPassCorrect){
            $error = 'Mauvais identifiant ou mot de passe !';
            $this->viewConnection($error);
        }
        else{
            $idMember = $member['idMember'];
            $_SESSION['id'] = $idMember;
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['status'] = $member['statusMember'];
            header('Location: index.php?action=member&id='.$idMember);
        }
    }

    //report a comment
    public function reportComment($comId, $memberId) {
        $this->comments->reportCom($comId);
        header('Location: index.php?action=member&id='.$memberId);
    }

    //report a member
    public function reportMember($memberId) {
        $this->member->reportMember($memberId);
        header('Location: index.php?action=member&id='.$memberId);
    }

    // display profil management
    public function viewProfileManagement($idMember)
    {
        $member = $this->member->getMember($idMember);
        $this->render('viewProfileManagement.php.twig', array(
            'member' => $member,
            'session' => $_SESSION
        ));
    }

    public function updateAvatar($idMember, $url){
        $this->member->updateAvatar($idMember, $url);
        header('Location: index.php?action=member&id='.$idMember);
    }
    public function updatePlace($idMember, $place){
        $this->member->updatePlace($idMember, $place);
        header('Location: index.php?action=member&id='.$idMember);
    }

}