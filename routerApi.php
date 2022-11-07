<?php 
require_once './libs/Router.php';
require_once 'controlerApi.php';

$router= new Router();

// defina la tabla de ruteo
$router->addRoute('repuestos', 'GET', 'controlerApi', 'getRepuestos');
$router->addRoute('repuestos', 'GET', 'controlerApi', 'getRepuesto');
$router->addRoute('repuestos', 'DELETE', 'controlerApi', 'deleteRepuesto');
$router->addRoute('repuestos', 'POST', 'controlerApi', 'insertRepuestR'); 

// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
