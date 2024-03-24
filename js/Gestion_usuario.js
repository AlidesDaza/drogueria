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
                <div usuarioId="${usuario.id}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                <div class="card bg-light">
                  <div class="card-header text-muted border-bottom-0">`;//estos if nos permiten identicar con un color en especifico  el tipo de rol
                  if(usuario.tipo_usuario==3){
                    template+=`<h1 class="badge badge-danger">${usuario.tipo}</h1>`;
                  }
                   
                  if(usuario.tipo_usuario==2){
                    template+=`<h1 class="badge badge-warning">${usuario.tipo}</h1>`;
                  }
                  if(usuario.tipo_usuario==1){
                    template+=`<h1 class="badge badge-info">${usuario.tipo}</h1>`;
                  }
                   
                   
                  template+=`
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
                        <img src="${usuario.avatar}" alt="" class="img-circle img-fluid">
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="text-right">`; // se utiliza comillas invertidas, para permitir la interpolación de variables y expresiones en una cadena
                    // se utilizaran estos if para ocultar el boton eliminar a los usuarios que no tienen prioridad, de igual manera para evitar que un usuario se borre así mismo

                    if(tipo_usuario==3){
                        if(usuario.tipo_usuario!=3){// en este if impide que se muestre el boton eliminar en el card del root pero si en los demas usuarios(administrador, tecnico)
                          template+=`
                            <button class=" borrar-usuario btn btn-danger mr-1" type="button" data-toggle="modal" data-target="#confirmar">
                                <i class="fas fa-window-close mr-2"> </i>Eliminar
                            </button>
                          `;
                        }
                        if(usuario.tipo_usuario==2){//este if es para incorporar un boton que permita ascender a los tecnicos a administradores
                          template+=`
                          <button class="ascender btn btn-primary ml-1" type="button" data-toggle="modal" data-target="#confirmar">
                              <i class="fas fa-sort-amount-up mr-2"> </i>Ascender
                          </button>
                        `;
                        }
                        if(usuario.tipo_usuario==1){
                          template+=`
                          <button class="descender btn btn-secondary ml-1 type="button" data-toggle="modal" data-target="#confirmar"">
                              <i class="fas fa-sort-amount-down mr-2"> </i>Descender
                          </button>
                        `;
                        }
                      }
                      else{// en este if si el tipo de usuario es administrador(2), podra mostrarse el boton eliminar solo para los tecnicos, pero no para el ni para el resto administradores, por tener la misma prioridad y mucho menos eliminar al root
                        
                          if(tipo_usuario==1 && usuario.tipo_usuario!=1 && usuario.tipo_usuario!=3){
                            template+=`
                            <button class=" borrar-usuario btn btn-danger" type="button" data-toggle="modal" data-target="#confirmar">
                                <i class="fas fa-window-clos mr-2"> </i>Eliminar
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
    });

//se crea el evento para ascender usuarios
    $(document).on('click','.ascender',(e)=>{
       const elemento= $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;// el colocar varios parentElemnt me permite ir ascendiendo a los atributos padres de los div, 
       //esto se hace con la finalidad de ubicarme en el div que contiene el  usuarioid
      const id=$(elemento).attr('usuarioId');//Aca se accede directamente el id de usuario seleccionado para ascender
       //console.log(id);// ya al hacer click en el boton ascender se obtiene el valor de id que le corresponde a ese usuario
       //ahora ese dato se debe pasar ese dato al modal por medio de los id de los imput ocultos en modal de confirmar contraseña
      funcion='ascender';
      $('#id_user').val(id);//por medio de este selector se envía al modal el valor que se quiere almacenar
      $('#funcion').val(funcion);
    });

//se crea el evento para descender usuarios es lo mismo que el anterior solo reeplazamos dnd dice ascender por descender y listo
        $(document).on('click','.descender',(e)=>{
          const elemento= $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;// el colocar varios parentElemnt me permite ir ascendiendo a los atributos padres de los div, 
          //esto se hace con la finalidad de ubicarme en el div que contiene el  usuarioid
         const id=$(elemento).attr('usuarioId');//Aca se accede directamente el id de usuario seleccionado para descender
          //console.log(id);// ya al hacer click en el boton ascender se obtiene el valor de id que le corresponde a ese usuario
          //ahora ese dato se debe pasar ese dato al modal por medio de los id de los imput ocultos en modal de confirmar contraseña
         funcion='descender';
         $('#id_user').val(id);//por medio de este selector se envía al modal el valor que se quiere almacenar
         $('#funcion').val(funcion);
       });
// Se crea el evento de eliminar
       $(document).on('click','.borrar-usuario',(e)=>{
        const elemento= $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;// el colocar varios parentElemnt me permite ir ascendiendo a los atributos padres de los div, 
        //esto se hace con la finalidad de ubicarme en el div que contiene el  usuarioid
       const id=$(elemento).attr('usuarioId');//Aca se accede directamente el id de usuario seleccionado para descender
        //console.log(id);// ya al hacer click en el boton ascender se obtiene el valor de id que le corresponde a ese usuario
        //ahora ese dato se debe pasar ese dato al modal por medio de los id de los imput ocultos en modal de confirmar contraseña
       funcion='borrar_usuario';
       $('#id_user').val(id);//por medio de este selector se envía al modal el valor que se quiere almacenar
       $('#funcion').val(funcion);
     });
// ahora se realiza el evento submit de ese modal accediendo al formulario "#form-confirmar"
        $('#form-confirmar').submit(e=>{
        let pass=$('#oldpass').val();
        let id_usuario=$('#id_user').val();
        funcion=$('#funcion').val();
        //  console.log(pass); console.log(id_usuario);console.log(funcion); estos console se crean para poder observar la captura de datos y ver que todo va bien
//se crea el Ajax de la siguiente manera URL del controlador, las variables y la funcion para obtener una respuesta(response) para hacer una funcion
        $.post('../controlador/UsuarioController.php',{pass,id_usuario,funcion},(response)=>{
          if(response=='ascendido'||response=='descendido'||response=='borrado'){
            $('#confirmado').hide('slow');//para que permanezca oculto
            $('#confirmado').show(2000);//para que el alert se muestr por 1 segundo
            $('#confirmado').hide(3000);//para que se oculten
            $('#form-confirmar').trigger('reset');//para que todos los campos queden vacios
  
          }
          else{
            $('#rechazado').hide('slow');//para que permanezca oculto
            $('#rechazado').show(2000);//para que el alert se muestr por 1 segundo
            $('#rechazado').hide(3000);//para que se oculten
            $('#form-confirmar').trigger('reset');//para que todos los campos queden vacios
  
          }
          buscar_datos();
        });
        e.preventDefault();
});
})