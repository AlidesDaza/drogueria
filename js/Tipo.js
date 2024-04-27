$(document).ready(function(){
 buscar_tip;//se coloca acá para que aparezcan todos los laboratorios
    var funcion;
    var edit=false;
    $('#form-crear-tipo').submit(e=>{
        let nombre_tipo = $('#nombre-tipo').val();
        let id_editado = $('#id_editar_tip').val();
        if(edit==false){
            funcion='crear';
        }
        else {
            funcion='editar';
        }
        funcion='crear';
        $.post('../controlador/TipoController.php',{nombre_tipo,id_editado,funcion},(response)=>{

            if(response=='add'){
                $('#add-tipo').hide('slow');//para que permanezca oculto
                $('#add-tipo').show(2000);//para que el alert se muestr por 1 segundo
                $('#add-tipo').hide(3000);//para que se oculten
                $('#form-crear-tipo').trigger('reset');//para que todos los campos queden vacios
             buscar_tip();//para que me aparezca el ingreso nuevo
            }
            if(response=='noadd'){

                $('#noadd-tipo').hide('slow');//para que permanezca oculto
                $('#noadd-tipo').show(2000);//para que el alert se muestr por 1 segundo
                $('#noadd-tipo').hide(3000);//para que se oculten
                $('#form-crear-tipo').trigger('reset');//para que todos los campos queden vacios
           
            }
            if(response=='edit'){
                $('#edit-tip').hide('slow');//para que permanezca oculto
                $('#edit-tip').show(2000);//para que el alert se muestr por 1 segundo
                $('#edit-tip').hide(3000);//para que se oculten
                $('#form-crear-tipo').trigger('reset');//para que todos los campos queden vacios
             buscar_tip();//para que me aparezca el ingreso nuevo
            
            }
            edit==false;
        })
        e.preventDefault(); 

    });

    function buscar_tip(consulta){
        funcion='buscar';
        $.post('../controlador/TipoController.php',{consulta,funcion},(response)=>{
           // console.log(response);
           const tipos = JSON.parse(response);
           let template='';
           tipos.forEach(tipo => {
            template+=`
            <tr tipId="${tipo.id}" tipNombre="${tipo.nombre}" >
                <td>
                    <button class="editar-tip btn btn-success" title="Editar Tipo" type="button"  data-toggle="modal" data-target="#creartipo">
                        <i class="far fa-pencil-alt"></i>
                    </button>
                    
                    <button class="borrar-tip btn btn-danger" title="Eliminar">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </td>
                <td>${tipo.nombre}</td>
            </tr>
            `;
            });
            $('#tipos').html(template);
        })
    }
    $(document).on('keyup','#buscar-tipo',function(){
        let valor = $(this).val();
        if(valor!=''){
         buscar_tip(valor);
        }
        else{
         buscar_tip();
        }
    })

    //Eliminar Tipo
    $(document).on('click','.borrar-tip',(e)=>{
        funcion="borrar";
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('tipId');// con esto obtengo el Id
        const nombre = $(elemento).attr('tipNombre');// con esto obtengo nombre
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
        icon:'warning',
        showCancelButton: true,
        confirmButtonText: "Si, desea borrar!",
        cancelButtonText: "No, cancelar!",
        reverseButtons: true
      }).then((result) => {
        if (result.value) {
            $.post('../controlador/TipoController.php',{id,funcion},(response)=>{
                edit==false;
                if(response=='borrado'){
                swalWithBootstrapButtons.fire({
                    title: "Borrado",
                    text: 'El Tipo '+nombre+'  fue borrado :)',
                    icon: "success"
                  });
                 buscar_tip();
              }
              else{
                swalWithBootstrapButtons.fire({
                    title: "No se pudo borrar!",
                    text: 'El Tipo '+nombre+'  no fue borrado ya que esta siendo utilizado por un producto',
                    icon: "error"
                  });
                 buscar_tip();
              }
            })

        } else if (result.dismiss === Swal.DismissReason.cancel) {
          swalWithBootstrapButtons.fire({
            title: "Cancelado",
            text: 'El Tipo '+nombre+'  no fue borrado :)',
            icon: "error"
          });
         buscar_tip();
        }
      });          
    })
    //Modificar Tipo

    $(document).on('click','.editar-tip',(e)=>{
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('tipId');// con esto obtengo el Id
        const nombre = $(elemento).attr('tipNombre');// con esto obtengo nombre
      $('#id_editar_tip').val(id);
      $('#nombre-tipo').val(nombre);
      edit=true;
    })
});