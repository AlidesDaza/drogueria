<?php
include_once '../modelo/Usuario.php';
$usuario = new Usuario();
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
           'adicional'=>$objeto->adicional_us

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

?>