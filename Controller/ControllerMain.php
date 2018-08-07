<?php
namespace AdelineD\OC\P9\Controller;

class ControllerMain {

    public function render($template, $array){
        $loader = new \Twig_Loader_Filesystem('View');
        $twig = new \Twig_Environment($loader, array(
            'cache' => 'twigCache',
        ));
        $temp = $twig->load($template);
        echo $temp->render($array);
    }


}