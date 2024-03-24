<?php
include_once '../modelo/Usuario.php';
$usuario = new Usuario();
session_start();
$id_usuario= $_SESSION['usuario'];
if($_POST['funcion']=='buscar_usuario'){
    $json=array();
    $fecha_actual = new DateTime();// se crea una variable y se invoca un objeto llamado DateTime, quien devielve fecha actual y tiempo
    $usuario->obtener_datos($_POST['dato']);//metodo invocar usuario, la cual obtendra todos los datos correspondiente a ese ID del usuario
    foreach ($usuario->objetos as $objeto){
        $nacimiento = new DateTime($objeto->edad);// variable nacimiento  la cual se convierte en un objeto DateTime
        $edad = $nacimiento->diff($fecha_actual);// el metodo diff compara la fecha actual con la de nacimiento y crea una resta
        $edad_years = $edad->y;// esta variable se crea para poder acceder a la diferencia del año y poder reeplazar en el campo edad para obtener la edad actualizada
        $json[]=array(
           'nombre'=>$objeto->nombre_us,
           'apellidos'=>$objeto->apellidos_us,
           'edad'=>$edad_years,// aqui se reeplaza la variable para que se muestre solo la edad en la vista
           'dni'=>$objeto->dni_us,
           'tipo'=>$objeto->nombre_tipo,
           'telefono'=>$objeto->telefono_us,
           'residencia'=>$objeto->residencia_us,
           'correo'=>$objeto->correo_us,
           'sexo'=>$objeto->sexo_us,
           'adicional'=>$objeto->adicional_us,
           'avatar'=>'../img/'.$objeto->avatar

        );
    }
    $jsonstring =json_encode($json[0]);//nos devuelve un json codificao, nos devuelve un strin para poderlo usar en nusetro Js
    echo $jsonstring;// se le envia el indice cero xq siempre va haber una sola concidencia, ya que el ID es unico
}
//esto nos permit mostrar  los datos usuario que vamos a editar en el formulario
if($_POST['funcion']=='capturar_datos'){
    $json=array();
    $id_usuario=$_POST['id_usuario'];
$usuario->obtener_datos($id_usuario);
    foreach ($usuario->objetos as $objeto){
        $json[]=array(
           'telefono'=>$objeto->telefono_us,
           'residencia'=>$objeto->residencia_us,
           'correo'=>$objeto->correo_us,
           'sexo'=>$objeto->sexo_us,
           'adicional'=>$objeto->adicional_us

        );
    }
    $jsonstring =json_encode($json[0]);//nos devuelve un json codificao, nos devuelve un strin para poderlo usar en nusetro Js
    echo $jsonstring;// se le envia el indice cero xq siempre va haber una sola concidencia, ya que el ID es unico
}

////esto nos permite guardar los datos usuario que editamos del formulario
if($_POST['funcion']=='editar_usuario'){
    $id_usuario=$_POST['id_usuario'];
    $telefono=$_POST['telefono'];
    $residencia=$_POST['residencia'];
    $correo=$_POST['correo'];
    $sexo=$_POST['sexo'];
    $adicional=$_POST['adicional'];
    $usuario->editar($id_usuario, $telefono ,$residencia, $correo, $sexo, $adicional);
    echo 'editado';
}
//Esto nos permite obtener los datos del formulario Cambiar contraseña  y modificarlos en la BD
if($_POST['funcion']=='cambiar_contra'){
    $id_usuario=$_POST['id_usuario'];
    $oldpass=$_POST['oldpass'];
    $newpass=$_POST['newpass'];
    $usuario->cambiar_contra($id_usuario,$oldpass,$newpass);// Acá se invoca al usuario, del modelo usuario que realiza el metodo cambiar contra, al cual se le pasa el Id_usuario, oldpass y newpass

  
}

if($_POST['funcion']=='cambiar_foto'){
    if(($_FILES['photo']['type']=='image/jpeg') ||($_FILES['photo']['type']=='image/png')||($_FILES['photo']['type']=='image/gif')){
        $nombre=uniqid().'-'.$_FILES['photo']['name'];
        $ruta='../img/'.$nombre;
        move_uploaded_file($_FILES['photo']['tmp_name'],$ruta);
        $usuario->cambiar_photo($id_usuario,$nombre);
        foreach($usuario->objetos as $objeto){
            unlink('../img/'.$objeto->avatar);//esta ruta nos permite reemplazar en la carpeta fisica la imagen anterior
        }
        $json= array();
        $json[]=array(
            'ruta'=>$ruta,
            'alert'=>'edit'
        );
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;

     }
     else{
        $json= array();
        $json[]=array(
            'alert'=>'noedit'
        );
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
     }

}

if($_POST['funcion']=='buscar_usuarios_adm'){
    $json=array();
    $fecha_actual = new DateTime();// se crea una variable y se invoca un objeto llamado DateTime, quien devielve fecha actual y tiempo
    $usuario->buscar();//metodo invocar usuario, la cual obtendra todos los datos correspondiente a ese ID del usuario
    foreach ($usuario->objetos as $objeto){
        $nacimiento = new DateTime($objeto->edad);// variable nacimiento  la cual se convierte en un objeto DateTime
        $edad = $nacimiento->diff($fecha_actual);// el metodo diff compara la fecha actual con la de nacimiento y crea una resta
        $edad_years = $edad->y;// esta variable se crea para poder acceder a la diferencia del año y poder reeplazar en el campo edad para obtener la edad actualizada
        $json[]=array(
           'id'=>$objeto->id_usuario,// por medio de esta asignacion de variables podremos ascede a la informacion del usuario para poder utilizar los botones ascender descender
           'nombre'=>$objeto->nombre_us,
           'apellidos'=>$objeto->apellidos_us,
           'edad'=>$edad_years,// aqui se reeplaza la variable para que se muestre solo la edad en la vista
           'dni'=>$objeto->dni_us,
           'tipo'=>$objeto->nombre_tipo,
           'telefono'=>$objeto->telefono_us,
           'residencia'=>$objeto->residencia_us,
           'correo'=>$objeto->correo_us,
           'sexo'=>$objeto->sexo_us,
           'adicional'=>$objeto->adicional_us,
           'avatar'=>'../img/'.$objeto->avatar,
           'tipo_usuario'=>$objeto->us_tipo  // esta variable se crea para comparar solo los id y no el string como se presenta en la variable 'tipo' declarada mas arriba
           //

        );
    }
    $jsonstring =json_encode($json);//nos devuelve un json codificao, nos devuelve un strin para poderlo usar en nusetro Js
    echo $jsonstring;
}
if($_POST['funcion']=='crear_usuario'){
    $nombre =$_POST['nombre'];
    $apellido =$_POST['apellido'];
    $edad =$_POST['edad'];
    $dni =$_POST['dni'];
    $pass =$_POST['pass'];
    $tipo =2;
    $avatar='default.png';
    $usuario->crear($nombre,$apellido,$edad,$dni,$pass,$tipo,$avatar);
}

if($_POST['funcion']=='ascender'){
    $pass=$_POST['pass'];
    $id_ascendido=$_POST['id_usuario'];
    $usuario->ascender($pass,$id_ascendido,$id_usuario);
}

if($_POST['funcion']=='descender'){
    $pass=$_POST['pass'];
    $id_descendido=$_POST['id_usuario'];
    $usuario->descender($pass,$id_descendido,$id_usuario);

}
// esta funcion es para eliminar usuario
if($_POST['funcion']=='borrar_usuario'){
    $pass=$_POST['pass'];
    $id_descendido=$_POST['id_usuario'];
    $usuario->borrar($pass,$id_descendido,$id_usuario);

}

?>