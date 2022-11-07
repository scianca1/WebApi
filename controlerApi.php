<?php 
require_once 'viewApi.php';
require_once 'modelRepuestos.php';

class ControlerApi{
private $model;
private $view;
private $data;

public function __construct()
{
   $this->model= new ModelApi();
   $this->view= new ViewApi();
   $this->data= $this->data = file_get_contents("php://input");
}
private function getdata()
{
   return json_decode($this->data);
}
public function getRepuestos($params= null)
{
 $repuestos= $this->model->getAll();
 $this->view->response($repuestos);
}
public function getrepuesto($params)
{
$id= $params[':ID'];
$repuesto=$this->model->getproduct($id);
$this->view->response($repuesto);
}
public function deleteRepuesto($params=null)
{
   $id= $params[':ID'];
   $repuesto=$this->model->getproduct($id);
   $this->model->deleteproducto($id); 
   $this->view->response($repuesto);
}
public function editRepuesto($params)
{
   $id= $params[':ID'];
   $body=$this->getdata();
   if(!empty($body->producto)&& !empty($body->material)&& !empty($body->precio) && !empty($body->id_categoria_fk)&& !empty($body->precio))
   {
   $repuesto=$this->model->editproducto($body->producto,$body->material,$body->precio,$body->id_categoria_fk,$body->ID); 
   $this->view->response($repuesto);
   }
   
}

}