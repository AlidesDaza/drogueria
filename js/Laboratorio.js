$(document).ready(function(){
    buscar_lab;//se coloca acá para que aparezcan todos los laboratorios
    var funcion;
    $('#form-crear-laboratorio').submit(e=>{
        let nombre_laboratorio = $('#nombre-laboratorio').val();
        funcion='crear';
        $.post('../controlador/LaboratorioController.php',{nombre_laboratorio,funcion},(response)=>{

            if(response=='add'){
                $('#add-laboratorio').hide('slow');//para que permanezca oculto
                $('#add-laboratorio').show(2000);//para que el alert se muestr por 1 segundo
                $('#add-laboratorio').hide(3000);//para que se oculten
                $('#form-crear-laboratorio').trigger('reset');//para que todos los campos queden vacios
                buscar_lab();//para que me aparezca el ingreso nuevo
            }
            else{

                $('#noadd-laboratorio').hide('slow');//para que permanezca oculto
                $('#noadd-laboratorio').show(2000);//para que el alert se muestr por 1 segundo
                $('#noadd-laboratorio').hide(3000);//para que se oculten
                $('#form-crear-laboratorio').trigger('reset');//para que todos los campos queden vacios
           
            }
        })
        e.preventDefault(); 

    });

    function buscar_lab(consulta){
        funcion='buscar';
        $.post('../controlador/LaboratorioController.php',{consulta,funcion},(response)=>{
           // console.log(response);
           const laboratorios = JSON.parse(response);
           let template='';
           laboratorios.forEach(laboratorio => {
            template+=`
            <tr labId="${laboratorio.id}" labNombre="${laboratorio.nombre}" labAvatar="${laboratorio.avatar}" >
                <td>
                    <button class="avatar btn btn-info" title="Cambiar logo laboratorio" type="button"  data-toggle="modal" data-target="#cambiologo">
                        <i class="far fa-image"></i>
                    </button>
                    
                    <button class="editar btn btn-success" title="Editar">
                        <i class="far fa-pencil-alt"></i>
                    </button>
                    
                    <button class="borrar btn btn-danger" title="Eliminar">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </td>
                <td><img src="${laboratorio.avatar}" class="img-fluid" rounded width="70" heigth="70"></td>
                <td>${laboratorio.nombre}</td>
            </tr>
            `;
            });
            $('#laboratorios').html(template);
        })
    }
    $(document).on('keyup','#buscar-laboratorio',function(){
        let valor = $(this).val();
        if(valor!=''){
            buscar_lab(valor);
        }
        else{
            buscar_lab();
        }
    })
    $(document).on('click','.avatar',(e)=>{
        funcion="cambiar_logo";
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('labId');// con esto obtengo el Id
        const nombre = $(elemento).attr('labNombre');// con esto obtengo nombre
        const avatar = $(elemento).attr('labAvatar');// con esto obtengo la imagen
       //ahora envío esos datos al modal
        $('#logoactual').attr('src',avatar);
        $('#nombre_logo').html(nombre);// htm xq no estoy usando un input ni el val, solo el texto
        $('#funcion').val(funcion);//con esto envio el nombre de la funcion al input de tipo hidden, para poder los los datos al modal
        $('#id_logo_lab').val(id);
    })

    $('#form-logo').submit(e=>{
        let formData = new FormData($('#form-logo')[0]);
        $.ajax({
            url:'../controlador/LaboratorioController.php',
            type:'POST',
            data:formData,
            cache:false,
            processData:false,
            contentType:false
        }).done(function(response){
            const json = JSON.parse(response);
            if(json.alert=='edit'){
                $('#logoactual').attr('src',json.ruta)
                $('#form-logo').trigger('reset');
                $('#edit').hide('slow');//para que permanezca oculto
                $('#edit').show(1000);//para que el alert se muestr por 1 segundo
                $('#edit').hide(2000);//para que se oculten
                 buscar_lab();
            }
            else{
                $('#noedit').hide('slow');//para que permanezca oculto
                $('#noedit').show(1000);//para que el alert se muestr por 1 segundo
                $('#noedit').hide(2000);//para que se oculten
                
            }
                      
        });
        e.preventDefault();
    })
    //Eliminar laboratorio
    $(document).on('click','.borrar',(e)=>{
        funcion="borrar";
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('labId');// con esto obtengo el Id
        const nombre = $(elemento).attr('labNombre');// con esto obtengo nombre
        const avatar = $(elemento).attr('labAvatar');// con esto obtengo la imagen
    // Codigo de SweetAlert2 Para que salga el boton de confirmar 
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-danger mr-2"
        },
        buttonsStyling: false
      });
      swalWithBootstrapButtons.fire({
        title: '¿ Desea Eliminar '+nombre+'?',
        text: "No se podra revertir la accion",
        imageUrl:''+avatar+'',
        imageWidth: 100,
        imageHeight:100,
        showCancelButton: true,
        confirmButtonText: "Si, desea borrar!",
        cancelButtonText: "No, cancelar!",
        reverseButtons: true
      }).then((result) => {
        if (result.value) {
            $.post('../controlador/LaboratorioController.php',{id,funcion},(response)=>{
              if(response=='borrado'){
                swalWithBootstrapButtons.fire({
                    title: "Borrado",
                    text: 'El laboratorio '+nombre+'  fue borrado :)',
                    icon: "success"
                  });
                  buscar_lab();
              }
              else{
                swalWithBootstrapButtons.fire({
                    title: "No se pudo borrar!",
                    text: 'El laboratorio '+nombre+'  no fue borrado ya que esta siendo utilizado por un producto',
                    icon: "error"
                  });
                  buscar_lab();
              }
            })

        } else if (result.dismiss === Swal.DismissReason.cancel) {
          swalWithBootstrapButtons.fire({
            title: "Cancelado",
            text: 'El laboratorio '+nombre+'  no fue borrado :)',
            icon: "error"
          });
          buscar_lab();
        }
      });          
    })
});