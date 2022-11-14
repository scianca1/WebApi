<?php 
require_once './libs/Router.php';
require_once './app/controlers/controlerApi.php';

$router= new Router();

// defina la tabla de ruteo
$router->addRoute('repuestos', 'GET', 'controlerApi', 'getRepuestos');
$router->addRoute('repuestos/:ID', 'GET', 'controlerApi', 'getRepuesto');
$router->addRoute('repuestos/:ID', 'DELETE', 'controlerApi', 'deleteRepuesto');
$router->addRoute('repuestos','PUT','controlerApi','editRepuesto');
$router->addRoute('repuestos', 'POST', 'controlerApi', 'insertRepuesto'); 
$router->addRoute('categoria', 'GET', 'ControlerApi', 'filterrepuestos');

// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
