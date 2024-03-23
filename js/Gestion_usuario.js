//Se crea un nuevo documento JS, ya que si usamos el usuario de JSpuede haber un error ya que pueden coincidir
//los id con los de la vista editar_datos_personales.
//se utiliza el selector para acceder a todo el documento
$(document).ready(function(){
    //si se presiona una tecla en buscar se va ejecutar esta funcion
    var tipo_usuario =$('#tipo_usuario').val();
   
   
    if(tipo_usuario==2){//este if oculta el boton 'crear usuario' al rol de tecnico
      $('#button-crear').hide();
    }

    buscar_datos();
    var funcion;
    function buscar_datos(consulta){
        funcion='buscar_usuarios_adm';
        $.post('../controlador/UsuarioController.php',{consulta,funcion},(response)=>{
            const usuarios = JSON.parse(response);
            let template='';
            usuarios.forEach(usuario=>{
                template+=`
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                <div class="card bg-light">
                  <div class="card-header text-muted border-bottom-0">
                    ${usuario.tipo}<!-- interpolacion  de variables -->
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-7">
                        <h2 class="lead"><b>${usuario.nombre} ${usuario.apellidos} </b></h2>
                        <p class="text-muted text-sm"><b>Sobre mí: </b>${usuario.adicional} </p>
                        <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-id-card"></i></span> Cedula:${usuario.dni} </li>
                        <li class="small"><span class="fa-li"><i class="fas fa-birthday-cake"></i></span> Edad:${usuario.edad} </li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Residencia:${usuario.residencia} </li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Telefono #: ${usuario.telefono}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-at"></i></span> Correo:${usuario.correo} </li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-smile-wink"></i></span> Sexo:${usuario.sexo} </li>
                          
                        </ul>
                      </div>
                      <div class="col-5 text-center">
                        <img src="../../dist/img/user2-160x160.jpg" alt="" class="img-circle img-fluid">
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="text-right">`; // se utiliza comillas invertidas, para permitir la interpolación de variables y expresiones en una cadena
                    // se utilizaran estos if para ocultar el boton eliminar a los usuarios que no tienen prioridad, de igual manera para evitar que un usuario se borre así mismo

                    if(tipo_usuario==3){
                        if(usuario.tipo_usuario!=3){// en este if impide que se muestre el boton eliminar en el card del root pero si en los demas usuarios(administrador, tecnico)
                          template+=`
                            <button class="btn btn-danger mr-1">
                                <i class="fas fa-window-close mr-2"> </i>Eliminar
                            </button>
                          `;
                        }
                        if(usuario.tipo_usuario==2){//este if es para incorporar un boton que permita ascender a los tecnicos a administradores
                          template+=`
                          <button class="btn btn-primary ml-1">
                              <i class="fas fa-window-close mr-2"> </i>Ascender
                          </button>
                        `;
                        }
                      }
                      else{// en este if si el tipo de usuario es administrador(2), podra mostrarse el boton eliminar solo para los tecnicos, pero no para el ni para el resto administradores, por tener la misma prioridad y mucho menos eliminar al root
                        
                          if(tipo_usuario==1 && usuario.tipo_usuario!=1 && usuario.tipo_usuario!=3){
                            template+=`
                            <button class="btn btn-danger">
                                <i class="fas fa-window-close mr-2"> </i>Eliminar
                            </button>
                          `;
                          }
                      }
                               
                      template+=` 
                        </div>
                      </div>
                    </div>
                  </div>
                    `;
                
            })
            $('#usuarios').html(template);
        });
    }
    $(document).on('keyup','#buscar',function(){
        let valor = $(this).val();//con this se selecciona el id buscar y con val su valor
        if(valor!=""){//si el valor es diferente de vacio va a escribir una letra y lo va buscar en e
            buscar_datos(valor);
        }
        else{// de lo contrario
          buscar_datos();
        }
    });

    $('#form-crear').submit(e=>{
      let nombre = $('#nombre').val();
      let apellido = $('#apellido').val();
      let edad = $('#edad').val();
      let dni = $('#dni').val();
      let pass = $('#pass').val();
      funcion='crear_usuario';
      $.post('../controlador/UsuarioController.php',{nombre,apellido,edad,dni,pass,funcion},(response)=>{
        if(response=='add'){
          $('#add').hide('slow');//para que permanezca oculto
          $('#add').show(2000);//para que el alert se muestr por 1 segundo
          $('#add').hide(3000);//para que se oculten
          $('#form-crear').trigger('reset');//para que todos los campos queden vacios
          buscar_datos()// esto es para que nos agregue el card el nuevo usuario
         }
         else{
          $('#noadd').hide('slow');//para que permanezca oculto
          $('#noadd').show(2000);//para que el alert se muestr por 1 segundo
          $('#noadd').hide(3000);//para que se oculten
          $('#form-crear').trigger('reset');//para que todos los campos queden vacios

         };
      });
      e.preventDefault();// anula el evento que por defecto a consecuencia del submit refresca la pagina
    })
})