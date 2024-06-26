<?php
include '../modelo/Laboratorio.php';
$laboratorio=new Laboratorio();
if($_POST['funcion']=='crear'){
    $nombre = $_POST['nombre_laboratorio'];
    $avatar='avatar01.png';
    $laboratorio->crear($nombre,$avatar);
}

//Para editar laboratorio
if($_POST['funcion']=='editar'){
    $nombre = $_POST['nombre_laboratorio'];
    $id_editado=$_POST['id_editado'];
    $laboratorio->editar($nombre,$id_editado);
}

if($_POST['funcion']=='buscar'){
    $laboratorio->buscar();//no se le pasa ningún parametro porque el valor lo vamos a captura en el modelo Laboratorio.php
    $json=array();
    foreach ($laboratorio->objetos as $objeto) {
        $json[]=array(
            'id'=>$objeto->id_laboratorio,
            'nombre'=>$objeto->nombre,
            'avatar'=>'../img/lab/'.$objeto->avatar
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
if($_POST['funcion']=='cambiar_logo'){
    $id=$_POST['id_logo_lab'];
    if(($_FILES['photo']['type']=='image/jpeg') ||($_FILES['photo']['type']=='image/png')||($_FILES['photo']['type']=='image/gif')){
        $nombre=uniqid().'-'.$_FILES['photo']['name'];
        $ruta='../img/lab/'.$nombre;
        move_uploaded_file($_FILES['photo']['tmp_name'],$ruta);
        $laboratorio->cambiar_logo($id,$nombre);
        foreach($laboratorio->objetos as $objeto){
            if($objeto->avatar!='avatar01.png'){
                unlink('../img/lab/'.$objeto->avatar);//esta ruta nos permite reemplazar en la carpeta fisica la imagen anterior
        //    Se hace este if para evitar que me elimine la imagen por defecto para los demas laboratorios que la tengan
               }
           
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
//funcion para eliminar Laboratorio
if($_POST['funcion']=='borrar'){
    $id=$_POST['id'];
    $laboratorio->borrar($id);
}
?>