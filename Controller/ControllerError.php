<?php
/**
 * Created by PhpStorm.
 * User: decaa
 * Date: 14/08/2018
 * Time: 11:59
 */

namespace AdelineD\OC\P9\Controller;


class ControllerError extends ControllerMain
{
    public function error($msgError){
        $this->render("viewError.php.twig", array('msgError' => $msgError));
    }
}