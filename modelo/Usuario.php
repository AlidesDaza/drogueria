<?php
 include_once 'Conexion.php';
 class Usuario{
    var $objetos;
    public function __construct(){
        $db = new Conexion();
        $this->acceso =$db->pdo;
    }
    function Loguearse($dni,$pass){
        $sql="SELECT * FROM usuario inner join tipo_us on us_tipo=id_tipo_us where dni_us=:dni and contrasena_us=:pass";
        $query= $this->acceso->prepare($sql);
        $query->execute(array(':dni'=>$dni,':pass'=>$pass));
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function obtener_datos($id){
        $sql="SELECT * FROM usuario join tipo_us on us_tipo=id_tipo_us and id_usuario=:id";
        $query= $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        $this->objetos=$query->fetchall();// aca nos busca todas las coicidencia que se realiza a la BD
        return $this->objetos;
    }
    function editar($id_usuario,$telefono,$residencia,$correo,$sexo,$adicional){
       $sql="UPDATE usuario SET telefono_us=:telefono, residencia_us=:residencia, correo_us=:correo, sexo_us=:sexo, adicional_us=:adicional where id_usuario=:id";
       $query= $this->acceso->prepare($sql);
       $query->execute(array(':id'=>$id_usuario,':telefono'=>$telefono,':residencia'=>$residencia,':correo'=>$correo,':sexo'=>$sexo,':adicional'=>$adicional));
    }
    //Metodo cambiar_contra, para cambiar la contraseña
    function cambiar_contra($id_usuario,$oldpass,$newpass){
        $sql="SELECT * FROM usuario where id_usuario=:id and contrasena_us=:oldpass";// esto se realiza para consultar primero que la contraseña vieja introducida por el usuario coincida con la almacenada en la base de datos para ese Id_usuario
        $query= $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id_usuario,':oldpass'=>$oldpass));
        $this->objetos = $query->fetchall();// aca nos realiza la consulta y busca todas las coicidencia que se realiza a la BD
        if(!empty($this->objetos)){
            $sql="UPDATE usuario SET contrasena_us=:newpass where id_usuario=:id";//se busca a el usuario id y en su campo contrasena_us se va colocar la nueva contraseña
            $query=$this->acceso->prepare($sql);//se accede primero al acceso PDO se le pasa el metodo prepare con el sql
            $query->execute(array(':id'=>$id_usuario,':newpass'=>$newpass));//en este query se realiza el metodo EXECUTE  para pasarle el array de las variables 
            echo 'update';
        }
         else{
            echo 'noupdate';
         }
     }
 }


 /* */
?>
