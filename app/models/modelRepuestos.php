<?php

class ModelApi{
    private $db;

    function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=web2;charset=utf8', 'root', '');
    }
    function getAll($sort="precio",$order=null)
    {
        $sentencia = $this->db->prepare("select * from productos ORDER BY $sort $order");
        $sentencia->execute();
        $repuestos = $sentencia->fetchAll(PDO::FETCH_OBJ);
         return $repuestos;
    }
    function getproduct($id)
    {
        $sentencia = $this->db->prepare("select * from productos WHERE ID=?");
        $sentencia->execute([$id]);
        $repuesto = $sentencia->fetch(PDO::FETCH_OBJ);
        return $repuesto;
    }
    function filterrepuestos($sort,$valor)
    {
        $sentencia = $this->db->prepare("select * from productos WHERE $sort=?");
        $sentencia->execute([$valor]);
        $repuestosdecat = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $repuestosdecat;
    }
    function deleteproducto($id)
    {
        $sentencia = $this->db->prepare("DELETE FROM productos WHERE ID=?");
        $sentencia->execute([$id]);
    }
    function insertproduct($producto, $material, $precio, $categoria, $img = null)
    {
        $pathimg = null;
        if ($img) {
            $pathimg = $this->uploadImage($img);
            $sentencia = $this->db->prepare("INSERT INTO productos(producto,material,precio,id_categoria_fk,img) VALUES(?,?,?,?,?)");
            $sentencia->execute([$producto, $material, $precio, $categoria, $pathimg]);
        } else {
            $sentencia = $this->db->prepare("INSERT INTO productos(producto,material,precio,id_categoria_fk) VALUES(?,?,?,?)");
            $sentencia->execute([$producto, $material, $precio, $categoria]);
        }
        return $this->db->lastInsertId();
    }
    private function uploadImage($img)
    {
        $target = 'imagen_db/' . uniqid() . '.jpg';
        move_uploaded_file($img, $target);
        return $target;
    }
    function editproducto($titulo, $material, $precio, $id_categoria, $id, $img = null)
    {
        $pathimg = null;
        if ($img) {
            $pathimg = $this->uploadImage($img);
            $sentencia = $this->db->prepare("UPDATE productos SET material=?,precio=?,producto=?,id_categoria_fk=?,img=? WHERE ID=?");
            $sentencia->execute([$material, $precio, $titulo, $id_categoria, $pathimg, $id]);
        }
        $sentencia = $this->db->prepare("UPDATE productos SET material=?,precio=?,producto=?,id_categoria_fk=? WHERE ID=?");
        $sentencia->execute([$material, $precio, $titulo, $id_categoria, $id]);
        $repuesto=$this->getproduct($id);
        return $repuesto;
    }
   
    
}