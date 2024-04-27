<?php
include '../modelo/Tipo.php';
$tipo=new Tipo();
if($_POST['funcion']=='crear'){
    $nombre = $_POST['nombre_tipo'];
    $tipo->crear($nombre);
}

//Para editar Tipo
if($_POST['funcion']=='editar'){
    $nombre = $_POST['nombre_tipo'];
    $id_editado=$_POST['id_editado'];
    $tipo->editar($nombre,$id_editado);
}

if($_POST['funcion']=='buscar'){
    $tipo->buscar();//no se le pasa ningún parametro porque el valor lo vamos a captura en el modelo Laboratorio.php
    $json=array();
    foreach ($tipo->objetos as $objeto) {
        $json[]=array(
            'id'=>$objeto->id_tip_prod,
            'nombre'=>$objeto->nombre,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

//funcion para eliminar Laboratorio
if($_POST['funcion']=='borrar'){
    $id=$_POST['id'];
    $tipo->borrar($id);
}
?>