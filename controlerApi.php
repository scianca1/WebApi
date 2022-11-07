<?php 
require_once 'viewApi.php';
require_once 'modelRepuestos.php';

class ControlerApi{
private $model;
private $view;

public function __construct()
{
   $this->model= new ModelApi();
   $this->view= new ViewApi();
}
}