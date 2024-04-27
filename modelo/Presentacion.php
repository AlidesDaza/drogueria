<?php
include 'Conexion.php';
class Presentacion{
    var $objetos;
    public function __construct(){
         $db=new Conexion();
        $this->acceso=$db->pdo;
    }
 //esta funcion corresponde a la creacion de usuarios por parte del ROOT
    function crear($nombre){
    $sql="SELECT id_presentacion FROM presentacion where nombre=:nombre";
    $query =$this->acceso->prepare($sql);
    $query->execute(array(':nombre'=>$nombre));
    $this->objetos=$query->fetchall(); 
    if(!empty($this->objetos)){
         echo 'noadd';
     }
    else{
        $sql="INSERT INTO presentacion(nombre) VALUES (:nombre)";
        $query =$this->acceso->prepare($sql);
        $query->execute(array(':nombre'=>$nombre));
        echo 'add';
        }
    }

    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta=$_POST['consulta'];
            $sql="SELECT * FROM presentacion where nombre LIKE :consulta";
            $query =$this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }   

        else{
            $sql="SELECT * FROM presentacion where nombre NOT LIKE '' ORDER BY id_presentacion LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }   

    }
       
         function borrar($id){
            $sql="DELETE FROM presentacion where id_presentacion=:id";// esto se realiza para saber si el usuario tiene imagen en la base de datos para ese Id_usuario
            $query= $this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id));
            if(!empty($query->execute(array(':id'=>$id)))){
                echo 'borrado';
            }
            else{
                echo 'noborrado';
            }
         }

        //  Funcion para editar laboratorio
        function editar($nombre,$id_editado){
            $sql="UPDATE presentacion SET nombre=:nombre Where id_presentacion=:id";
            $query = $this->acceso->prepare(sql);
            $query->execute(array(':id'=>$id_editado,':nombre'=>$nombre));
            echo 'edit';
        }
}

?>