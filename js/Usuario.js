$(document).ready(function(){
    var funcion='';
    var id_usuario = $('#id_usuario').val();// estamos capturando el valor del id_usuario
   // console.log(id_usuario);
   var edit=false;
   buscar_usuario(id_usuario);
    function buscar_usuario(dato){
        funcion='buscar_usuario';
        $.post('../controlador/UsuarioController.php',{dato,funcion},(response)=>{
//  se crean los template y se concatenan  
           let nombre ='';
           let apellidos ='';
           let edad ='';
           let dni='';
           let tipo ='';
           let telefono ='';
           let residencia='';
           let  correo='';
           let sexo='';
           let adicional='';
           const usuario = JSON.parse(response); // hace lo contrario del encode, extrae todos los atributos 
            nombre+=`${usuario.nombre}`;
            apellidos+=`${usuario.apellidos}`;
            edad +=`${usuario.edad}`;
            dni+=`${usuario.dni}`;
            tipo+=`${usuario.tipo}`;
            telefono+=`${usuario.telefono}`;
            residencia+=`${usuario.residencia}`;
            correo+=`${usuario.correo}`;
            sexo+=`${usuario.sexo}`;
            adicional+=`${usuario.adicional}`;
            // ahora usamos los selectores para poder pasar a cada uno de los id del html
            $('#nombre_us').html(nombre);
            $('#apellidos_us').html(apellidos);
            $('#edad').html(edad);
            $('#dni_us').html(dni);
            $('#us_tipo').html(tipo);
            $('#telefono_us').html(telefono);
            $('#residencia_us').html(residencia);
            $('#correo_us').html(correo);
            $('#sexo_us').html(sexo);
            $('#adicional_us').html(adicional);


        })//se crea un ajax('url',{},) tipo post requiere la url los datos y la funcion que se va a ejecutar
    }
    $(document).on('click','.edit',(e)=>{
        funcion='capturar_datos';
        edit=true;
        $.post('../controlador/UsuarioController.php',{funcion,id_usuario},(response)=>{
         const usuario = JSON.parse(response);
         $('#telefono').val(usuario.telefono);
         $('#residencia').val(usuario.residencia);
         $('#correo').val(usuario.correo);
         $('#sexo').val(usuario.sexo);
         $('#adicional').val(usuario.adicional);
        })
    });
    $('#form-usuario').submit(e=>{
        if(edit==true){
            let telefono=$('#telefono').val();
            let residencia=$('#residencia').val();
            let correo=$('#correo').val();
            let sexo=$('#sexo').val();
            let adicional=$('#adicional').val();
            funcion='editar_usuario';
            $.post('../controlador/UsuarioController.php',{id_usuario,funcion,telefono,residencia,correo,sexo,adicional},(response)=>{
              // console.log(response);
                if(response=='editado'){
                  $('#editado').hide('slow');//para que permanezca oculto
                    $('#editado').show(2000);//para que el alert se muestr por 1 segundo
                    $('#editado').hide(3000);//para que se oculten
                    $('#form-usuario').trigger('reset');//para que todos los campos queden vacios
                }
                edit=false;// para que se desactive la bandera y no quede siempre habiltado para editar
                buscar_usuario(id_usuario);
            })
        }
        else{
           $('#noeditado').hide('slow');//para que permanezca oculto
            $('#noeditado').show(2000);//para que el alert se muestr por 1 segundo
            $('#noeditado').hide(3000);//para que se oculten
            $('#form-usuario').trigger('reset');//para que todos los campos queden vacios
       
        }
        e.preventDefault();
    })

    $('#form-pass').submit(e=>{
        let oldpass=$('#oldpass').val();
        let newpass=$('#newpass').val();
       // console.log(oldpass + newpass); para comprobar que esta capturando los datos del input
        funcion='cambiar_contra';
        $.post('../controlador/UsuarioController.php',{id_usuario,funcion,oldpass,newpass},(response)=>{
           // console.log(response);
           if(response=='update'){
            $('#update').hide('slow');//para que permanezca oculto
            $('#update').show(2000);//para que el alert se muestr por 1 segundo
            $('#update').hide(3000);//para que se oculten
            $('#form-pass').trigger('reset');//para que todos los campos queden vacios
       
           }
           else{
            $('#noupdate').hide('slow');//para que permanezca oculto
            $('#noupdate').show(2000);//para que el alert se muestr por 1 segundo
            $('#noupdate').hide(3000);//para que se oculten
            $('#form-pass').trigger('reset');//para que todos los campos queden vacios
       
           }
        });//ya que se accede a la contraseña que corresponde a la tabla usuario
        e.preventDefault();//Para evitar que se refresque la pagina.

    });

})//nos permite ejecutar funciones una vez cargada la pagina actual