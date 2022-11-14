<?php
require_once './app/views/viewApi.php';
require_once './app/models/modelRepuestos.php';

class ControlerApi
{
   private $model;
   private $view;
   private $data;
   private $sort;


   public function __construct()
   {
      $this->model = new ModelApi();
      $this->view = new ViewApi();
      $this->data = $this->data = file_get_contents("php://input");
      $this->sort = isset($_GET['sort']) ? $this->sort = $_GET['sort'] : null;
   }
   private function getdata()
   {
      return json_decode($this->data);
   }
   public function getRepuestos($params = null)
   {
      if (!empty($_GET['sort']) && !empty($_GET['order'])) {
         $order = $_GET['order'];
         $repuestos = $this->model->getAll($this->sort, $order);
         $this->view->response($repuestos);
      } else if (!empty($_GET['sort'])) {
         $repuestos = $this->model->getAll($this->sort);
         $this->view->response($repuestos);
      } else {
         $repuestos = $this->model->getAll();
         $this->view->response($repuestos);
      }
   }
   public function getrepuesto($params)
   {
      $id = $params[':ID'];
      $repuesto = $this->model->getproduct($id);
      $this->view->response($repuesto);
   }
   public function deleteRepuesto($params = null)
   {
      $id = $params[':ID'];
      $repuesto = $this->model->getproduct($id);
      $this->model->deleteproducto($id);
      $this->view->response($repuesto);
   }
   public function editRepuesto($params)
   {
      $ID = $params[':ID'];
      $body = $this->getdata();
      if (!empty($body->producto) && !empty($body->material) && !empty($body->precio) && !empty($body->id_categoria_fk) && !empty($body->precio)) {
         $repuesto = $this->model->editproducto($body->producto, $body->material, $body->precio, $body->id_categoria_fk, $ID);
         $this->view->response($repuesto);
      }
   }
   public function insertRepuesto()
   {
      try {
         $repuesto = $this->getdata();
         if (empty($repuesto->producto) || empty($repuesto->precio) || empty($repuesto->material) || empty($repuesto->id_categoria_fk)) {
            $this->view->response("complete todos los campos", 400);
         } else {
            $id = $this->model->insertproduct($repuesto->producto, $repuesto->material, $repuesto->precio, $repuesto->id_categoria_fk);
            $repuesto = $this->model->getproduct($id);
            $this->view->response($repuesto, 201, "se agrego correctamemte el producto con id=$id");
         }
      } catch (\Throwable $th) {
         $this->view->response("nos se encontro el error", 500);
      }
   }
   public function filterrepuestos()
   {
      try {
         if(!empty($_GET['sort'])&& !empty($_GET['valor'])){
         $sort = $_GET['sort'];
         $valor=$_GET['valor'];
         $repuestos = $this->model->filterrepuestos($sort,$valor);
            if ($repuestos) {
               $this->view->response($repuestos, 200, "Mostrando " . count($repuestos) . " repuestos de con el $sort= $valor");
            }
         }
         else{
            $this->view->response("debes llenar los campos", 400);
         }
      
      } catch (\Throwable $th) {
         $this->view->response("no se encontro el error", 500);
      }
   }
}
