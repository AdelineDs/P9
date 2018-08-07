<?php
session_start();
//twig autoload
require_once 'vendor/autoload.php';

require('Engine/Router.php');

$router = new Router();
$router->routerQuery();
     
       
  