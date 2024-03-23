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
  <!-- Button trigger modal -->
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
                                <input id="nombre" type="text" class="form-control" placeholder="Ingrese Nombre"required>
                            </div>
                            <div class="form-group">
                                <label for="apellido">Apellidos</label>
                                <input id="apellido"  type="text" class="form-control" placeholder="Ingrese Apellido"required>
                            </div>
                            <div class="form-group">
                                <label for="edad">Fecha Nacimiento</label>
                                <input id="edad" type="date" class="form-control" placeholder="YYYY-MM-DD"required>
                            </div>
                            <div class="form-group">
                                <label for="dni">Cedula Ciudadania</label>
                                <input id="dni" type="text" class="form-control" placeholder="111111111 Sin puntos"required>
                            </div>
                            <div class="form-group">
                                <label for="pass">Contraseña</label>
                                <input id="pass" type="pass" class="form-control" placeholder="Ingrese contraseña"required>
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