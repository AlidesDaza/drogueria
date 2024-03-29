<?php
session_start();
if($_SESSION['us_tipo']==1||$_SESSION['us_tipo']==3){// se realiza este if para verificar que el usuario logueado tiene rol de administrador
include_once'layouts/header.php';
?>

  <title>Editar Datos</title>
  <!-- Tell the browser to be responsive to screen width -->
  <?php
    include_once'layouts/nav.php';
  ?>
  

  <!-- Este Modal nos permite mostrar un formulario de confirmacion de contraseña
    ccon el fin de darle mayor seguridad al sistema y así evitar vulnerabilidades en el mismo -->
<div class="modal fade" id="confirmar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmar Accion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center"><img src="../img/avatar01.png" class="profile-user-img img-fluid img-circle"></div>
      </div>
      <div class="text-center">
        <b>
            <?php 
                echo $_SESSION['nombre_us'];
            ?>
        </b>
      </div>
      <span>Se requiere password para confirmar accion</span>
      <div class="alert alert-success text-center" id="confirmado" style='display:none;'>
            <span><i class="fas fa-check m-1" ></i>Se modifico al usuario!</span>
      </div>
      <div class="alert alert-danger text-center" id="rechazado" style='display:none;'>
        <span><i class="fas fa-times m-1"></i> La contraseña no es correcta</span>
      </div>
      <form id="form-confirmar">
            <div class="input-group mb-3">
                <div class="input-group-prepend ">
                  <span class="input-group-text"><i class="fas fa-unlock-alt"></i> </span>
                </div>
                <input id="oldpass" type="password" class="form-control" placeholder="Ingrese password Actual">
                <input type="hidden" id="id_user"><!-- Estos input van a estar ocultos, estos datos se llenaran por los botones ascender y descender-->
                <input type="hidden" id="funcion">
              </div>


           <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn bg-gradient-primary">Guardar Cambios</button>
     </form>
      </div>
    </div>
  </div>
</div>
    <div class="modal fade" id="crearusuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-tittle">Crear Usuario</h3>
                        <button  data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success text-center" id="add" style='display:none;'>
                           <span><i class="fas fa-check m-1" ></i>Usuario nuevo creado exitosamente!!</span>
                        </div>
                        <div class="alert alert-danger text-center" id="noadd" style='display:none;'>
                           <span><i class="fas fa-times m-1"></i> Cedula Ya existe para otro usuario</span>
                        </div>
                        <form id="form-crear">
                            <div class="form-group">
                                <label for="nombre">Nombres</label>
                                <input id="nombre" pattern="^[ a-zA-ZñÑáéíóúÁÉÍÓÚ]+$" type="text" class="form-control" placeholder="Ingrese Nombre"required>
                            </div>
                            <div class="form-group">
                                <label for="apellido">Apellidos</label>
                                <input id="apellido" pattern="^[ a-zA-ZñÑáéíóúÁÉÍÓÚ]+$"  type="text" class="form-control" placeholder="Ingrese Apellido"required>
                            </div>
                            <div class="form-group">
                                <label for="edad">Fecha Nacimiento</label>
                                <input id="edad" type="date" class="form-control"  min="1924-01-01" max="2008-12-31"placeholder="DD-MM-YYYY"required pattern="/^(?:(?:(?:0?[1-9]|1\d|2[0-8])[/](?:0?[1-9]|1[0-2])|(?:29|30)[/](?:0?[13-9]|1[0-2])|31[/](?:0?[13578]|1[02]))[/](?:0{2,3}[1-9]|0{1,2}[1-9]\d|0?[1-9]\d{2}|[1-9]\d{3})|29[/]0?2[/](?:\d{1,2}(?:0[48]|[2468][048]|[13579][26])|(?:0?[48]|[13579][26]|[2468][048])00))$/">
                            </div>
                            <div class="form-group">
                                <label for="dni">Cedula Ciudadania</label>
                                <input id="dni"  pattern="\\d{5}[A-HJ-NP-TV-Z]" min="99999" max="999999999"  type="number" class="form-control" placeholder="111111111 Sin puntos"required>
                            </div>
                            <div class="form-group">
                                <label for="pass">Contraseña</label>
                                <input id="pass" type="password" pattern=".{5,12}"  mixlength="5" maxlength="12" class="form-control" placeholder="Ingrese contraseña"required> 
                            </div>
                       
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar Datos</button>
                        <button type="button"  data-dismiss="modal" class="btn bg-gradient-secondary float-right m-1">Cerrar</button>
                        
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestion Usuarios <button id="button-crear" type="button" data-toggle="modal" data-target="#crearusuario" class="btn bg-gradient-primary ml-2">Crear Usuarios</button></h1>
            <input type="hidden" id="tipo_usuario" value="<?php echo $_SESSION['us_tipo']?>">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Gestion Usuarios</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section>
    <div class="container-fluid">
        <div class="card-success">
            <div class="card-header">
                <h3 class="card-tittle">Buscar usuario</h3>
                <div class="input-group">
                    <input type="text"  id="buscar" class="form-control float-left" placeholder="ingrese nombre de usuario">
                    <div class="input-group-append">
                        <button class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
            <div  class="card-body">
                <div id="usuarios" class="row d-flex align-items-stretch">

                </div>

            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
    </section>
  </div>
  <!-- /.content-wrapper -->
<?php
include_once 'layouts/footer.php';
} // se utilza entre codigo php para poder usar la llave y que afecte al codigo Html el if
else{
    header('Location: ../index.php');
}
?>
<script src="../js/Gestion_usuario.js"></script>