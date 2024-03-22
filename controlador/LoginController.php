<!--// Se crean Variables para el inicio de sesion-->
<?php 
 include_once '../modelo/Usuario.php';// con esto llamamos a usuario
session_start();
$user = $_POST['user'];//echo $user; echo " ";
$pass = $_POST['pass'];//echo $pass; con estos Echo mostramos en pantalla a modo de prueba de que se almacenan las variables
// luego debemos verificar que los datos ingresados en el formulario estan en nuestra BD
$usuario = new Usuario();// instanciamos para que se nos haga la conexion

if(!empty($_SESSION['us_tipo'])){// si hay una sesion en curso debe realizarse el switch
   //session_destroy();
    switch ($_SESSION['us_tipo']) {// se crea un switch para verificar que tipo de usuario a iniciado session
        case 1:// si se da este case se va al perfil del admin
            header('location: ../vista/adm_catalogo.php');// nos redireciona a la pagina del administrador
        break;
    
        case 2:// si se da este case se va al perfil del tecnico
            header('Location: ../vista/tec_catalogo.php');// nos redireciona a la pagina del tecnico.
        break;

        case 3:// si se da este case se va al perfil del Administrador
            header('Location: ../vista/adm_catalogo.php');// nos redireciona a la pagina del tecnico.
        break;
    }
}
else{ //control de acceso y direccionamiento de roles
     $usuario->Loguearse($user,$pass);// usamos el metodo loguearse, correspondienta POO y pasarle las funciones para que retorne un objeto
if(!empty($usuario->objetos)){// si encuentra un ususario verifica que rol tiene y direcciona a una  vista segun perfil
    foreach ($usuario->objetos as $objeto){
        $_SESSION['usuario']=$objeto->id_usuario; //se crean la variables de sesion
        $_SESSION['us_tipo']=$objeto->us_tipo;//estas son las columnas de nuestra base de datos(solo las que nos interesa usar)
        $_SESSION['nombre_us']=$objeto->nombre_us;// de la tabla usuario
    
        }
        switch ($_SESSION['us_tipo']) {// se crea un switch para verificar que tipo de usuario a iniciado session
            case 1:// si se da este case se va al perfil del admin
                header('location: ../vista/adm_catalogo.php');// nos redireciona a la pagina del administrador
            break;
        
            case 2:// si se da este case se va al perfil del tecnico
                header('Location: ../vista/tec_catalogo.php');// nos redireciona a la pagina del tecnico.
            break;
                    
            case 3:// si se da este case se va al perfil del Administrador
                header('Location: ../vista/adm_catalogo.php');// nos redireciona a la pagina del tecnico.
            break;
        }

    }
    else{// se emplea este else en caso de que el usuario no este en la BD
            header('Location: ../index.php');// con lo cual no vuelve a retornar al login
    }
}
?>
