//Se crea un nuevo documento JS, ya que si usamos el usuario de JSpuede haber un error ya que pueden coincidir
//los id con los de la vista editar_datos_personales.
//se utiliza el selector para acceder a todo el documento
$(document).ready(function(){
    //si se presiona una tecla en buscar se va ejecutar esta funcion
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
                    <div class="text-right">
                        <button class="btn btn-danger">
                            <i class="fas fa-window-close mr-2"> </i>Eliminar
                        </button>
                    </div>
                  </div>
                </div>
              </div>
                `;
                
            })
            $('#usuarios').html(template)
        });
    }
    $(document).on('keyup','#buscar',function(){
        let valor = $(this).val();//con this se selecciona el id buscar y con val su valor
        if(valor!=""){//si el valor es diferente de vacio va a escribir una letra y lo va buscar en e
            buscar_datos(valor)
        }
        else{// de lo contrario
            console.log(valor);
        }
    })
});