<?php

/**
 * Web Service RESTful en PHP con MySQL (CRUD)
 * *
 * @author mroblesdev
 * @link https://github.com/mroblesdev/web_service_php
 * @license: MIT
 */

require 'conexionApi.php';

$conexion = new Conexion();
$pdo = $conexion->obtenerConexion();

// Listar registros y consultar registro
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $sql = "SELECT * FROM usuario";// acá se hace una consulta de todos los campos que contiene esta tabla
    $params = [];


    //este If se utiliza para traer la informacion de un solo registro.
    if (isset($_GET['id_usuario'])) {
        $sql .= " WHERE id_usuario=:id";
        $params[':id'] = $_GET['id_usuario'];
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);//Este es un fet asociativo y con esto ya se tiene todos los datos
    header("HTTP/1.1 200 OK");//Se requiere para enviar una respuesta HTTP, para confirmar que la respuesta es correcta
    echo json_encode($stmt->fetchAll());//Para poder regresarlo a un web service se le asigna en formato JSON codificado
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // $sql = "INSERT INTO usuario (nombre, telefono, email) VALUES(:nombre, :telefono, :email)";
    $sql="INSERT INTO usuario(nombre_us,apellidos_us,edad,dni_us,contrasena_us,us_tipo,avatar) VALUES (:nombre,:apellido,:edad,:dni,:pass,:tipo,:avatar)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':nombre', $_POST['nombre_us']);
    $stmt->bindValue(':apellido', $_POST['apellido_us']);
    $stmt->bindValue(':edad', $_POST['edad']);
    $stmt->bindValue(':dni', $_POST['dni_us']);
    $stmt->bindValue(':pass', $_POST['contrasena_us']);
    $stmt->bindValue(':tipo', $_POST['us_tipo']);
    $stmt->bindValue(':avatar', $_POST['avatar']);
    $stmt->execute();
    $idPost = $pdo->lastInsertId();//esto nos sirve para ver el id que se creo
    if ($idPost) {
        header("HTTP/1.1 200 Ok");
        echo json_encode($idPost);
        exit;
    }
}

// Metodo PUT para Actualizar registro
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $sql="UPDATE usuario 
          SET nombre_us=:nombre, apellidos_us=:apellido, edad=:edad, dni_us=:dni, contrasena_us=:pass, us_tipo=:tipo, avatar=:avatar
          WHERE id_usuario=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':nombre',$_GET['nombre_us']);
    $stmt->bindValue(':apellido', $_GET['apellido_us']);
    $stmt->bindValue(':edad', $_GET['edad']);
    $stmt->bindValue(':dni', $_GET['dni_us']);
    $stmt->bindValue(':pass', $_GET['contrasena_us']);
    $stmt->bindValue(':tipo', $_GET['us_tipo']);
    $stmt->bindValue(':avatar', $_GET['avatar']);
    $stmt->bindValue(':id', $_GET['id_usuario']);
    $stmt->execute();
    echo "Registro Actualizado Correctamente";
    header("HTTP/1.1 200 Ok");
    exit;
}



//Metodo DELETE para Eliminar registro
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $sql = "DELETE FROM usuario WHERE id_usuario=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $_GET['id_usuario']);
    $stmt->execute();
    header("HTTP/1.1 200 Ok");
    exit;
}

// Si no coincide con ningún método de solicitud, devolver Bad Request
header("HTTP/1.1 400 Bad Request");
