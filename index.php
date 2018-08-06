<?php
session_start();

require('Engine/Router.php');

$router = new Router();
$router->routerQuery();
     
       
  