<?php
include 'Conexion.php';
class Laboratorio{
    var $objetos;
    public function __construct(){
         $db=new Conexion();
        $this->acceso=$db->pdo;
    }
 //esta funcion corresponde a la creacion de usuarios por parte del ROOT
    function crear($nombre,$avatar){
    $sql="SELECT id_laboratorio FROM laboratorio where nombre=:nombre";
    $query =$this->acceso->prepare($sql);
    $query->execute(array(':nombre'=>$nombre));
    $this->objetos=$query->fetchall(); 
    if(!empty($this->objetos)){
         echo 'noadd';
     }
    else{
        $sql="INSERT INTO laboratorio(nombre,avatar) VALUES (:nombre,:avatar)";
        $query =$this->acceso->prepare($sql);
        $query->execute(array(':nombre'=>$nombre,':avatar'=>$avatar));
        echo 'add';
        }
    }

    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta=$_POST['consulta'];
            $sql="SELECT * FROM laboratorio where nombre LIKE :consulta";
            $query =$this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }   

        else{
            $sql="SELECT * FROM laboratorio where nombre NOT LIKE '' ORDER BY id_laboratorio LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }   

    }
         //Metodo cambiar_photo, para cambiar el avatar
        function cambiar_logo($id,$nombre){
            $sql="SELECT avatar FROM laboratorio where id_laboratorio=:id";// esto se realiza para saber si el usuario tiene imagen en la base de datos para ese Id_usuario
            $query= $this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id));
            $this->objetos = $query->fetchall();// aca nos realiza la consulta y busca todas las coicidencia que se realiza a la BD
            
            $sql="UPDATE laboratorio SET avatar=:nombre where id_laboratorio=:id";//se busca a el usuario id y en su campo contrasena_us se va colocar la nueva contraseña
            $query=$this->acceso->prepare($sql);//se accede primero al acceso PDO se le pasa el metodo prepare con el sql
            $query->execute(array(':id'=>$id,':nombre'=>$nombre));//en este query se realiza el metodo EXECUTE  para pasarle el array de las variables 
            return $this->objetos;
         }
}

?>