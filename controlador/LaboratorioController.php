<?php
include '../modelo/Laboratorio.php';
$laboratorio=new Laboratorio();
if($_POST['funcion']=='crear'){
    $nombre = $_POST['nombre_laboratorio'];
    $avatar='avatar01.png';
    $laboratorio->crear($nombre,$avatar);
}

if($_POST['funcion']=='buscar'){
    $laboratorio->buscar();//no se le pasa ningún parametro porque el valor lo vamos a captura en el modelo Laboratorio.php
    $json=array();
    foreach ($laboratorio->objetos as $objeto){
        $json[]=array(
            'id'=>$objeto->id_laboratorio,
            'nombre'=>$objeto->nombre,
            'avatar'=>'../img/'.$objeto->avatar
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
?>