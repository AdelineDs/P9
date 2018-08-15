<?php
namespace AdelineD\OC\P9\Controller;

class ControllerMap extends ControllerMain {

    //display map page
    public function map(){
        $this->render('viewMap.php.twig', array('session' => $_SESSION));
    }
}