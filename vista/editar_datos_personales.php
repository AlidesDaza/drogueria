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


<!-- Modal -->
<div class="modal fade" id="cambiocontra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cambiar Contrasena</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center"><img id="avatar3" src="../img/avatar01.png" class="profile-user-img img-fluid img-circle"></div>
      </div>
      <div class="text-center">
        <b>
            <?php 
                echo $_SESSION['nombre_us'];
            ?>
        </b>
      </div>
      <div class="alert alert-success text-center" id="update" style='display:none;'>
            <span><i class="fas fa-check m-1" ></i>Contraseña Actualizada con exito!!</span>
      </div>
      <div class="alert alert-danger text-center" id="noupdate" style='display:none;'>
        <span><i class="fas fa-times m-1"></i> La contraseña no es correcta</span>
      </div>
      <form id="form-pass">
            <div class="input-group mb-3">
                <div class="input-group-prepend ">
                  <span class="input-group-text"><i class="fas fa-unlock-alt"></i> </span>
                </div>
                <input id="oldpass" type="password" class="form-control" placeholder="Ingrese password Actual">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend ">
                  <span class="input-group-text"><i class="fas fa-lock"></i> </span>
                </div>
                <input id="newpass" type="text" class="form-control" placeholder="Ingrese contrasena nueva">
            </div>
        
           <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn bg-gradient-primary">Guardar Cambios</button>
     </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="cambiophoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cambiar avatar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <img id="avatar1" src="../img/avatar01.png" class="profile-user-img img-fluid img-circle"></div>
      </div>
      <div class="text-center">
        <b>
            <?php 
                echo $_SESSION['nombre_us'];
            ?>
        </b>
      </div>
      <div class="alert alert-success text-center" id="edit" style='display:none;'>
            <span><i class="fas fa-check m-1" ></i>Avatar cambiado con exito!!</span>
      </div>
      <div class="alert alert-danger text-center" id="noedit" style='display:none;'>
        <span><i class="fas fa-times m-1"></i>Formato de imagen no soportado</span>
      </div>
      <form id="form-photo" enctype="multipart/form-data">
            <div class="input-group mb-3 ml-5 mt-2">
            <input type="file" name="photo" class="input-group">
            <input type="hidden" name="funcion" value="cambiar_foto">
          
            </div>

           <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn bg-gradient-primary">Guardar Cambios</button>
     </form>
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
            <h1>Datos Personales</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Datos Personales</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section>
        <div class="content">
                <div class="container-fluid"><!-- /.container-fluid ES UNA CLASE DE BOOTSTRAP -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-success card-outline"><!-- el card-outline crea una linea. card-success le da el color verde  -->
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img id='avatar2' src="../img/avatar01.png"  class="profile-user-img img-fluid img-circle">
                                    </div>
                                    <div class="text-center mt-1">
                                      <button  type='button' data-toggle="modal" data-target="#cambiophoto" class="btn btn-primary btn-sm">Cambiar</button>
                                    </div>
                                    <input id="id_usuario" type="hidden" value="<?php echo $_SESSION['usuario']?>">
                                    <h3 id="nombre_us" class="profile-username text-center text-success">Nombre</h3>
                                    <p  id="apellidos_us"class="text-muted text-center">Apellido</p>
                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b style="color:#0B7300">Edad</b><a id="edad" class="float-right">25</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b style="color:#0B7300">DNi</b><a id="dni_us" class="float-right">12</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b style="color:#0B7300">Tipo de usuario</b>
                                            <span id="us_tipo" class=" float-right "> Admistrador</span><!-- El badge es una insignia que resalta. badge-primary le da un color azul -->
                                        </li>
                                        <button data-toggle="modal" data-target="#cambiocontra" type="button" class="btn btn-block btn-outline-warning btn-sm">Cambiar Contrasena</button>
                                    </ul>
                                </div>
                            </div>
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-tittle">Sobre Mí</h3>
                                </div>
                                <div class="card-body">
                                    <strong style="color:#0B7300">
                                    <i class="fas fa-phone mr-1"></i>Telefono
                                    </strong>
                                    <p id="telefono_us" class="text-muted">9354637</p>

                                    <strong style="color:#0B7300">
                                    <i class="fas fa-map-marker-alt mr-1"></i>Residencia
                                    </strong>
                                    <p ID="residencia_us" class="text-muted">Nueva Deli 324</p>

                                    <strong style="color:#0B7300">
                                    <i class="fas fa-at mr-1"></i>Correo
                                    </strong>
                                    <p id="correo_us" class="text-muted">abc@gmail.com</p>

                                    <strong style="color:#0B7300">
                                    <i class="fas fa-smile-wink mr-1"></i>Sexo
                                    </strong>
                                    <p id="sexo_us" class="text-muted">Masculino</p>
                                
                                    <strong style="color:#0B7300">
                                    <i class="fas fa-pencil-alt mr-1"></i>Informacion Adicional
                                    </strong>
                                    <p id="adicional_us" class="text-muted">Nueva Deli 324</p>

                                    <button class="edit btn btn-block bg-gradient-danger">Editar</button>
                                </div>
                                <div class="card-footer">
                                    <p class="text-muted"> Click si desea editar</p>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-tittle">Editar Datos Personales</h3>
                                </div>
                                <div class="card-body">
                                 <div class="alert alert-success text-center" id="editado" style='display:none;'>
                                        <span><i class="fas fa-check m-1" ></i>Editado</span>
                                    </div>
                                    <div class="alert alert-danger text-center" id="noeditado" style='display:none;'>
                                      <span><i class="fas fa-times m-1"></i> No esta habilitado la ediccion</span>
                                    </div>
                                    <form id='form-usuario' class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="telefono" class="col-sm-2 col-form-label">Telefono</label>
                                            <div class="col-sm-10">
                                                <input type="tel" pattern="[0-9]{10}"  id="telefono" class="form-control"><!--no usamo name xq vamos usar javaScript, empleamos el Id para poder seleccionarla -->
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="residencia" class="col-sm-2 col-form-label">Residencia</label>
                                            <div class="col-sm-10">
                                                <input type="text" id="residencia" class="form-control"><!--no usamo name xq vamos usar javaScript, empleamos el Id para poder seleccionarla -->
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="correo" class="col-sm-2 col-form-label">Correo</label>
                                            <div class="col-sm-10">
                                                <input type="email" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" id="correo" class="form-control"><!--no usamo name xq vamos usar javaScript, empleamos el Id para poder seleccionarla -->
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="sexo" class="col-sm-2 col-form-label">Sexo</label>
                                            <div class="col-sm-10">
                                                <input type="text" id="sexo" class=" form-control"><!--no usamo name xq vamos usar javaScript, empleamos el Id para poder seleccionarla -->
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="adicional" class="col-sm-2 col-form-label">Inf. Adicional</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control row"  id="adicional" cols="30" rows="10"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10 float-right">
                                                <button class="btn btn-block btn-outline-success">Guardar</button>
                                            </div>
                                        </div>


                                    </form>
                                </div>
                                <div class="card-footer">
                                    <p class="text-muted">No ingresar Datos Erroneos</p>

                                </div>

                            </div>

                        </div>
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
<script src="../js/Usuario.js"></script>