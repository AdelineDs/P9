<?php

use \AdelineD\OC\P9\Controller\ControllerHome;
use \AdelineD\OC\P9\Controller\ControllerError;
use \AdelineD\OC\P9\Controller\ControllerMap;
use \AdelineD\OC\P9\Controller\ControllerPhotos;
use \AdelineD\OC\P9\Controller\ControllerPhotosAjax;
use \AdelineD\OC\P9\Controller\ControllerMember;
use \AdelineD\OC\P9\Controller\ControllerVote;
use \AdelineD\OC\P9\Controller\ControllerAdmin;
use \Intervention\Image\ImageManager;

//class autoloading
require_once 'Autoloader.php';
Autoloader::register();

class Router {
    
    private $ctrlHome;
    private $ctrlError;
    private $ctrlMap;
    private $ctrlPhotos;
    private $ctrlPhotosAjax;
    private $ctrlMember;
    private $ctrlVote;
    private $ctrlAdmin;
    private $manager;


    public function __construct() {
        $this->ctrlHome = new ControllerHome();
        $this->ctrlMap = new ControllerMap();
        $this->ctrlPhotos = new ControllerPhotos();
        $this->ctrlPhotosAjax = new ControllerPhotosAjax();
        $this->ctrlMember= new ControllerMember();
        $this->ctrlError = new ControllerError();
        $this->ctrlVote = new ControllerVote();
        $this->ctrlAdmin = new ControllerAdmin();
        $this->manager = new ImageManager();
    }


    public function routerQuery(){
        try{
            if(isset($_GET['action'])){
                if ($_GET['action'] == 'map'){
                    $this->ctrlMap->map();
                }
                elseif ($_GET['action'] == 'getPictures')
                {
                    $this->ctrlPhotos->getPictures();
                }
                elseif ($_GET['action'] == 'getAroundPhotos')
                {
                    if (isset($_GET["latMin"])&&isset($_GET["latMax"])&&isset($_GET["lngMin"])&&isset($_GET["lngMax"])&&isset($_GET["photosArray"])) {
                        $latMin = $_GET["latMin"];
                        $latMax = $_GET["latMax"];
                        $lngMin = $_GET["lngMin"];
                        $lngMax = $_GET["lngMax"];
                        $photosArray = $_GET["photosArray"];
                        $this->ctrlPhotosAjax->getAroundPhotos($latMin, $latMax, $lngMin, $lngMax, $photosArray);
                    }
                    else{
                        throw new \Exception( "Données non présentes");
                    }
                }
                //display a member page
                elseif ($_GET['action'] == 'member'){
                    $idMember = intval($this->getParam($_GET, 'id'));
                    if ($idMember > 0){
                        if (isset($_SESSION['id']) && isset($_SESSION['pseudo'])){
                            if (!empty($_SESSION['id']) && !empty($_SESSION['pseudo'])){
                                $this->ctrlMember->memberPage($idMember, $_SESSION['id']);
                            }else{
                                throw new \Exception("Erreur lors de la récupération de la session");
                            }
                        }else{
                            $this->ctrlMember->memberPage($idMember);
                        }
                    }
                    else{
                        throw new \Exception("Identifiant de membre non valide.");
                    }
                }
                //send comment
                elseif ($_GET['action'] == 'comment'){
                    if(!empty($_POST['author']) && !empty($_POST['comment'])){
                        $author = $this->getParam($_POST, 'author');
                        $comment = $this->getParam($_POST, 'comment');
                        $idMember = $this->getParam($_POST, 'id');
                        $this->ctrlMember->comment($idMember, $author, $comment);
                    }
                    else{
                        throw new \Exception("Tous les champs ne sont pas remplis !");
                    }
                }
                //diplay registration form
                elseif ($_GET['action'] == 'registrationForm'){
                    $this->ctrlMember->viewRegistration();
                }
                //do the regostration for a new member
                elseif ($_GET['action'] == 'registration'){
                    if(!empty($_POST['pseudo']) && !empty($_POST['pass1']) && !empty($_POST['pass2']) && !empty($_POST['email'])){
                        $pseudo = $this->getParam($_POST, 'pseudo');
                        $pass1 = $this->getParam($_POST, 'pass1');
                        $pass2 = $this->getParam($_POST, 'pass2');
                        $email = $this->getParam($_POST, 'email');
                        $this->ctrlMember->registration($pseudo, $pass1, $pass2, $email);
                    }
                    else{
                        $error = "Tous les champs ne sont pas remplis";
                        $this->ctrlMember->viewRegistration($error);
                    }
                }
                //display connect form
                elseif ($_GET['action'] == 'connectForm'){
                    $this->ctrlMember->viewConnection();
                }
                //connect a member
                elseif ($_GET['action'] == 'connectMember') {
                    if (isset($_POST['pseudo']) && $_POST['pass']) {
                        if (!empty($_POST['pseudo']) && !empty($_POST['pass'])) {
                            $pseudo = $this->getParam($_POST, 'pseudo');
                            $pass = $this->getParam($_POST, 'pass');
                            $this->ctrlMember->connection($pseudo, $pass);
                        }
                        else{
                            $error = "Tous les champs ne sont pas remplis";
                            $this->ctrlMember->viewConnection($error);
                        }
                    }
                }
                //display form for add photo
                elseif ($_GET['action'] == 'addPhoto'){
                    $this->ctrlPhotos->viewAddPhoto();
                }
                //add a photo in member gallery
                elseif ($_GET['action'] == 'confirmAdd'){
                    if (isset($_FILES['photo']['tmp_name']) && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['lat']) && isset($_POST['lng']) && isset($_POST['status']) && isset($_POST['idMember'])){
                        if (!empty($_FILES['photo']['tmp_name']) && !empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['lat']) && !empty($_POST['lng'])){
                            $title = $this->getParam($_POST, 'title');
                            $description = $this->getParam($_POST, 'description');
                            $lat = $this->getParam($_POST, 'lat');
                            $lng = $this->getParam($_POST, 'lng');
                            $status = intval($this->getParam($_POST, 'status'));
                            $idMember = intval($this->getParam($_POST, 'idMember'));
                            $sizeMax = 1000000;
                            $file = basename($_FILES['photo']['name']);
                            $fileSize = filesize($_FILES['photo']['tmp_name']);
                            $extends = array('.png', '.gif', '.jpg', '.jpeg');
                            $extend = strtolower(strrchr($_FILES['photo']['name'], '.'));
                            if(in_array($extend, $extends)) //Si l'extension est dans le tableau
                            {
                                if($fileSize < $sizeMax) {
                                    if (is_numeric($lat) && is_numeric($lng)) {
                                        $folder = 'public/img/';
                                        $file = uniqid() . $extend;
                                       /* $this->manager->make($_FILES['photo']['tmp_name'])
                                            ->resize(700, null, function ($constraint) {
                                                $constraint->aspectRatio();
                                            })
                                            ->save('public/img/700-' . $file);
                                        $this->manager->make($_FILES['photo']['tmp_name'])
                                            ->resize(150, null, function ($constraint) {
                                                $constraint->aspectRatio();
                                            })
                                            ->save('public/img/150-' . $file);
                                        $this->manager->make($_FILES['photo']['tmp_name'])
                                            ->resize(1600, null, function ($constraint) {
                                                $constraint->aspectRatio();
                                            })
                                            ->save('public/img/1600-' . $file);*/
                                        if (move_uploaded_file($_FILES['photo']['tmp_name'], $folder . $file)) {
                                            $url = $folder . $file;
                                            $this->ctrlPhotos->addPhoto($idMember, $title, $description, $url, $lat, $lng, $status);
                                        }
                                        else {
                                            $error = "Echec de l'upload de la photo.";
                                            $this->ctrlPhotos->viewAddPhoto($error);
                                        }
                                    }
                                    else{
                                        $error = "La longitude et la latitude doivent être des valeurs numériques";
                                        $this->ctrlPhotos->viewAddPhoto($error);
                                    }

                                }
                                else{
                                    $error = 'Le fichier est trop gros...';
                                    $this->ctrlPhotos->viewAddPhoto($error);
                                }
                            }
                            else{
                                $error = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg,...';
                                $this->ctrlPhotos->viewAddPhoto($error);
                            }
                        }
                        else{
                            $error = "Tous les champs ne sont pas remplis";
                            $this->ctrlPhotos->viewAddPhoto($error);
                        }
                    }
                    else{
                        $error = "Un problème est survenu durant le chargement";
                        $this->ctrlPhotos->viewAddPhoto($error);
                    }
                }
                //disconnect
                elseif ($_GET['action'] == 'disconnect'){
                    session_unset();
                    session_destroy();
                    header('Location: index.php');
                }
                //report a comment
                elseif ($_GET['action'] == 'reportCom'){
                    $comId = intval($this->getParam($_POST, 'comId'));
                    $memberId = intval($this->getParam($_POST, 'memberId'));
                    $this->ctrlMember->reportComment($comId, $memberId);
                }
                //like or dislike a photo
                elseif ($_GET['action'] == 'vote'){
                    $photoId = intval($this->getParam($_POST, 'photoId'));
                    $memberId = intval($this->getParam($_POST, 'memberId'));
                    $likedMemberId = intval($this->getParam($_POST, 'likedMemberId'));
                    $this->ctrlVote->vote($photoId, $memberId, $likedMemberId);
                }
                //display the reported comments management page
                elseif ($_GET['action'] == 'comManagement'){
                    if (isset($_SESSION['id']) && isset($_SESSION['pseudo']) && isset($_SESSION['status'])){
                        if (!empty($_SESSION['id']) && !empty($_SESSION['pseudo']) && isset($_SESSION['status'])){
                            if ($_SESSION['status'] == 1){
                                $this->ctrlAdmin->viewComManagement();
                            }
                            else{
                                throw new \Exception("Vous n'êtes pas autorisé à accéder à cette page.");
                            }
                        }
                        else{
                            throw new \Exception("Un erreur est survenue durant la récupération des données de sessions");
                        }
                    }
                    else{
                        throw new \Exception("Impossible de récupérer les données de sessions");
                    }

                }
                //sent to comment moderation form
                elseif ($_GET['action'] == 'moderateCom') {
                    $idCom = intval($this->getParam($_GET, 'id'));
                    if ($idCom != 0) {
                        $this->ctrlAdmin->moderationForm($idCom);
                    }
                    else {
                        $error = "Identifiant de commentaire non valide";
                        $this->ctrlAdmin->viewComManagement($error);
                    }
                }
                //confirms the modification of a comment
                elseif ($_GET['action'] == 'confirmModerationCom') {
                    if (isset($_POST['author']) && isset($_POST['comment']) && isset($_POST['idCom'])){
                        if(!empty($_POST['author']) && !empty($_POST['comment']) && !empty($_POST['idCom'])){
                            $idCom = $this->getParam($_POST, 'idCom');
                            $author = $this->getParam($_POST, 'author');
                            $comment = $this->getParam($_POST, 'comment');
                            $this->ctrlAdmin->moderateCom($idCom, $author, $comment);
                        }
                        else{
                            throw new \Exception("Tous les champs ne sont pas remplis !");
                        }
                    }
                    else{
                        throw new \Exception("Une erreur est survenue durant la récupération des données");
                    }
                }
                //send to the confirmation page deleting a comment
                elseif ($_GET['action'] == 'deleteCom') {
                    $idCom = intval($this->getParam($_GET, 'id'));
                    if ($idCom != 0) {
                        $this->ctrlAdmin->viewComConfirmation($idCom);
                    }
                    else {
                        $error = "Identifiant de commentaire non valide";
                        $this->ctrlAdmin->viewComManagement($error);
                    }
                }
                //delete comment
                elseif ($_GET['action'] == 'confirmDeleteCom') {
                    if (isset($_POST['idCom'])){
                        if (!empty($_POST['idCom'])){
                            $idCom = $this->getParam($_POST, 'idCom');
                            $this->ctrlAdmin->confirmDeleteCom($idCom);
                        }
                        else{
                            $error = "Erreur avec l'identifiant de commentaire";
                            $this->ctrlAdmin->viewComManagement($error);
                        }
                    }
                    else{
                        $error = "Erreur avec l'identifiant de commentaire";
                        $this->ctrlAdmin->viewComManagement($error);
                    }
                }
                //display the admin management page
                elseif ($_GET['action'] == 'membersManagement'){
                    if (isset($_SESSION['id']) && isset($_SESSION['pseudo']) && isset($_SESSION['status'])){
                        if (!empty($_SESSION['id']) && !empty($_SESSION['pseudo']) && !empty($_SESSION['status'])){
                            if ($_SESSION['status'] == 1){
                                $this->ctrlAdmin->viewMembersManagement();
                            }
                            else{
                                throw new \Exception("Vous n'êtes pas autorisé à accéder à cette page.");
                            }
                        }
                        else{
                            throw new \Exception("Un erreur est survenue durant la récupération des données de sessions");
                        }
                    }
                    else{
                        throw new \Exception("Impossible de récupérer les données de sessions");
                    }

                }
                //report a comment
                elseif ($_GET['action'] == 'reportMember'){
                    $memberId = intval($this->getParam($_POST, 'memberId'));
                    $this->ctrlMember->reportMember($memberId);
                }
                //display confirm delete member page
                elseif ($_GET['action'] == 'deleteMember'){
                    $idMember = intval($this->getParam($_GET, 'id'));
                    if (isset($_SESSION['id']) && isset($_SESSION['pseudo']) && isset($_SESSION['status'])){
                        if (!empty($_SESSION['id']) && !empty($_SESSION['pseudo']) && !empty($_SESSION['status'])){
                            if ($_SESSION['status'] == 1){
                                if ($idMember != 0){
                                    $this->ctrlAdmin->viewMemberConfirmation($idMember);
                                }
                                else{
                                    throw new \Exception("Identifiant de membre non valide");
                                }
                            }
                            else{
                                throw new \Exception("Vous n'êtes pas autorisé à accéder à cette page.");
                            }
                        }
                        else{
                            throw new \Exception("Un erreur est survenue durant la récupération des données de sessions");
                        }
                    }
                    else{
                        throw new \Exception("Impossible de récupérer les données de sessions");
                    }
                }
                //delete member
                elseif ($_GET['action'] == 'confirmDeleteMember') {
                    if (isset($_POST['idMember'])){
                        if (!empty($_POST['idMember'])){
                            $idMember = $this->getParam($_POST, 'idMember');
                            $this->ctrlAdmin->confirmDeleteMember($idMember);
                        }
                        else{
                            $error = "Erreur avec l'identifiant du membre";
                            $this->ctrlAdmin->viewMembersManagement($error);
                        }
                    }
                    else{
                        throw new \Exception("Impossible de récupérer l'id du memebre");
                    }
                }
                elseif ($_GET['action'] == 'legalNotice'){
                    $this->ctrlHome->legalNotice();
                }
                elseif ($_GET['action'] == 'profileManagement'){
                    if (isset($_SESSION['id']) && isset($_SESSION['pseudo'])){
                        if (!empty($_SESSION['id']) && !empty($_SESSION['pseudo'])){
                            $idMember = $this->getParam($_SESSION, 'id');
                            $this->ctrlMember->viewProfileManagement($idMember);
                        }
                        else{
                            throw new \Exception("Une erreur s'est produite durant la récupération des données de session");
                        }
                    }
                    else{
                        throw new \Exception("Impossible de récupérer les données de sessions");
                        error_log('coucou');
                    }
                }
                // update a member profile
                elseif ($_GET['action'] == 'updateProfile'){
                    if (isset($_POST['place']) && isset($_POST['idMember'])){
                        if (!empty($_POST['idMember'])){
                            $place = $this->getParam($_POST, 'place');
                            $idMember = intval($this->getParam($_POST, 'idMember'));
                            $sizeMax = 500000;
                            $file = basename($_FILES['avatar']['name']);
                            $fileSize = filesize($_FILES['avatar']['tmp_name']);
                            $extends = array('.png', '.jpg', '.jpeg');
                            $extend = strtolower(strrchr($_FILES['avatar']['name'], '.'));
                            if (!empty($_FILES['avatar']['tmp_name'])){
                                if(in_array($extend, $extends)) //Si l'extension est dans le tableau
                                {
                                    if($fileSize < $sizeMax) {
                                        $folder = 'public/avatar/';
                                        $file = uniqid().$extend;
                                        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $folder . $file)){
                                            $url = $folder.$file;
                                            $this->ctrlMember->updateAvatar($idMember, $url);
                                        }
                                        else{
                                            $error = "Echec de l'upload de la photo.";
                                            $this->ctrlMember->viewProfileManagement($error);
                                        }

                                    }
                                    else{
                                        $error = 'Le fichier est trop gros...';
                                        $this->ctrlMember->viewProfileManagement($error);
                                    }
                                }
                                else{
                                    $error = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg,...';
                                    error_log('coucou');
                                    $this->ctrlMember->viewProfileManagement($error);
                                }
                            }
                            if (!empty($_POST['place'])){
                                $this->ctrlMember->updatePlace($idMember, $place);
                            }
                        }
                        else{
                            $error = "Erreur dans la récupération de id du membre";
                            $this->ctrlMember->viewProfileManagement($error);
                        }
                    }
                    else{
                        $error = "Un problème est survenu durant le chargement";
                        $this->ctrlMember->viewProfileManagement($error);
                    }
                }
                //display photo edit page
                elseif ($_GET['action'] == 'editPhoto'){
                    $idphoto = intval($this->getParam($_GET, 'id'));
                    if ($idphoto > 0){
                        if (isset($_SESSION['id']) && isset($_SESSION['pseudo'])){
                            if (!empty($_SESSION['id']) && !empty($_SESSION['pseudo'])){
                                $this->ctrlPhotos->viewPhotoEditing($idphoto, $_SESSION['id']);
                            }else{
                                throw new \Exception("Erreur lors de la récupération de la session");
                            }
                        }else{
                            throw new \Exception("Vous n'avez pas l'autorisation d'aller sur cette page");
                        }
                    }
                    else{
                        throw new \Exception("Identifiant de photo non valide.");
                    }
                }
                //edit a photo in member gallery
                elseif ($_GET['action'] == 'confirmEdit'){
                    if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['lat']) && isset($_POST['lng']) && isset($_POST['status'])  && isset($_POST['idPhoto'])) {
                        if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['lat']) && !empty($_POST['lng']) && !empty($_POST['idMember']) && !empty($_POST['idPhoto'])) {
                            $title = $this->getParam($_POST, 'title');
                            $description = $this->getParam($_POST, 'description');
                            $lat = $this->getParam($_POST, 'lat');
                            $lng = $this->getParam($_POST, 'lng');
                            $status = intval($this->getParam($_POST, 'status'));
                            $idMember = intval($this->getParam($_POST, 'idMember'));
                            $idphoto = intval($this->getParam($_POST, 'idPhoto'));
                            if (is_numeric($lat) && is_numeric($lng)){
                                $this->ctrlPhotos->editPhoto($idMember, $idphoto, $title, $description, $lat, $lng, $status);
                            }else{
                                $error = "La longitude et la latitude doivent être des valeurs numériques";
                                $this->ctrlPhotos->viewPhotoEditing($idphoto, $idMember, $error);
                            }
                        }
                        else{
                            $error = "Tous les champs ne sont pas remplis";
                            $this->ctrlPhotos->viewPhotoEditing($error);
                        }
                    }
                    else{
                        $error = "Un problème est survenu durant le chargement";
                        $this->ctrlPhotos->viewPhotoEditing($error);
                    }
                }
                //send to the confirmation page deleting a photo
                elseif ($_GET['action'] == 'deletePhoto') {
                    $idPhoto = intval($this->getParam($_POST, 'idPhoto'));
                    $idMember = intval($this->getParam($_POST, 'idMember'));
                    if ($idPhoto != 0) {
                        $this->ctrlPhotos->viewConfirmation($idPhoto, $idMember);
                    }
                    else {
                        $error = "Identifiant de photo non valide";
                        $this->ctrlPhotos->viewPhotoEditing($idPhoto, $idMember, $error);
                    }
                }
                //delete photo
                elseif ($_GET['action'] == 'confirmDeletePhoto') {
                    if (isset($_POST['idPhoto']) && isset($_POST['urlPhoto']) && isset($_SESSION['id'])){
                        if (!empty($_POST['idPhoto']) && !empty($_POST['urlPhoto']) && !empty($_SESSION['id'])){
                            $idPhoto = intval($this->getParam($_POST, 'idPhoto'));
                            $urlPhoto = $this->getParam($_POST, 'urlPhoto');
                            $idMember = intval($this->getParam($_SESSION, 'id'));
                            $this->ctrlPhotos->confirmDeletePhoto($idPhoto, $urlPhoto, $idMember);
                        }
                        else{
                            $error = "Erreur avec l'identifiant du membre";
                            $this->ctrlAdmin->viewMembersManagement($error);
                        }
                    }
                    else{
                        throw new \Exception("Impossible de récupérer l'id du membre");
                    }
                }
                //if action don't exist
                else{
                    throw new \Exception("Action non valide");
                }
            }
            // default action home page
           else{
               $this->ctrlHome->home();
            } 
        }
        catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
    
    private function getParam($array, $name){
        if(isset($array[$name])){
            return $array[$name];
        }else{
            throw new \Exception("Paramètre '$name' absent");
        }
    }

    private function error($msgError){
        $this->ctrlError->error($msgError);
    }
}//--end class Router      

