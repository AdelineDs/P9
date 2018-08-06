<?php
namespace AdelineD\OC\P9\Controller;

use \AdelineD\OC\P9\View\View;

class ControllerHome {


  //display home page
  public function home(){
      $loader = new \Twig_Loader_Filesystem('View'); // Dossier contenant les templates
      $twig = new \Twig_Environment($loader, array(
          'cache' => false
      ));

      echo $twig->render('viewHome.php.twig', array());

    // $view = new View("Home");
    // $view->generate(array());
  }
}