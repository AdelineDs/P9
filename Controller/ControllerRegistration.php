<?php
namespace AdelineD\OC\P9\Controller;

use \AdelineD\OC\P9\View\View;

class ControllerRegistration {


    //display Registration page
    public function view(){
        $loader = new \Twig_Loader_Filesystem('View'); // Dossier contenant les templates
        $twig = new \Twig_Environment($loader, array(
            'cache' => false
        ));

        echo $twig->render('viewRegistrationForm.php.twig', array());

        // $view = new View("RegistrationForm");
        // $view->generate(array());
    }
}