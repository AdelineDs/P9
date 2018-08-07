<?php
namespace AdelineD\OC\P9\Controller;

class ControllerHome extends ControllerMain {


  //display home page
  public function home(){
      $this->render('viewHome.php.twig', array());
  }
}