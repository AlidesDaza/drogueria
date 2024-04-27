$(document).ready(function(){
    buscar_pre();//se coloca acá para que aparezcan todos los laboratorios
       var funcion;
       var edit=false;
       $('#form-crear-presentacion').submit(e=>{
           let nombre_presentacion = $('#nombre-presentacion').val();
           let id_editado = $('#id_editar_pre').val();
           if(edit==false){
               funcion='crear';
           }
           else {
               funcion='editar';
           }
           funcion='crear';
           $.post('../controlador/PresentacionController.php',{nombre_presentacion,id_editado,funcion},(response)=>{
   
               if(response=='add'){
                   $('#add-pre').hide('slow');//para que permanezca oculto
                   $('#add-pre').show(2000);//para que el alert se muestr por 1 segundo
                   $('#add-pre').hide(3000);//para que se oculten
                   $('#form-crear-presentacion').trigger('reset');//para que todos los campos queden vacios
                buscar_pre();//para que me aparezca el ingreso nuevo
               }
               if(response=='noadd'){
   
                   $('#noadd-pre').hide('slow');//para que permanezca oculto
                   $('#noadd-pre').show(2000);//para que el alert se muestr por 1 segundo
                   $('#noadd-pre').hide(3000);//para que se oculten
                   $('#form-crear-presentacion').trigger('reset');//para que todos los campos queden vacios
              
               }
               if(response=='edit'){
                   $('#edit-pre').hide('slow');//para que permanezca oculto
                   $('#edit-pre').show(2000);//para que el alert se muestr por 1 segundo
                   $('#edit-pre').hide(3000);//para que se oculten
                   $('#form-crear-presentacion').trigger('reset');//para que todos los campos queden vacios
                buscar_pre();//para que me aparezca el ingreso nuevo
               
               }
               edit==false;
           })
           e.preventDefault(); 
   
       });
   
       function buscar_pre(consulta){
           funcion='buscar';
           $.post('../controlador/PresentacionController.php',{consulta,funcion},(response)=>{
              // console.log(response);
              const presentaciones = JSON.parse(response);
              let template='';
              presentaciones.forEach(presentacion => {
               template+=`
               <tr preId="${presentacion.id}" preNombre="${presentacion.nombre}" >
                   <td>
                       <button class="editar-pre btn btn-success" title="Editar Presentacion" type="button"  data-toggle="modal" data-target="#crearpresentacion">
                           <i class="fas fa-pencil-alt"></i>
                       </button>
                       
                       <button class="borrar-pre btn btn-danger" title="Eliminar">
                           <i class="far fa-trash-alt"></i>
                       </button>
                   </td>
                   <td>${presentacion.nombre}</td>
               </tr>
               `;
               });
               $('#presentaciones').html(template);
           })
       }
       $(document).on('keyup','#buscar-presentacion',function(){
           let valor = $(this).val();
           if(valor!=''){
            buscar_pre(valor);
           }
           else{
            buscar_pre();
           }
       })
   
       //Eliminar presentacion
       $(document).on('click','.borrar-pre',(e)=>{
           funcion="borrar";
           const elemento = $(this)[0].activeElement.parentElement.parentElement;
           const id = $(elemento).attr('preId');// con esto obtengo el Id
           const nombre = $(elemento).attr('preNombre');// con esto obtengo nombre
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
               $.post('../controlador/PresentacionController.php',{id,funcion},(response)=>{
                   edit==false;
                   if(response=='borrado'){
                   swalWithBootstrapButtons.fire({
                       title: "Borrado",
                       text: 'La presentacion '+nombre+'  fue borrado :)',
                       icon: "success"
                     });
                    buscar_pre();
                 }
                 else{
                   swalWithBootstrapButtons.fire({
                       title: "No se pudo borrar!",
                       text: 'La presentacion ' +nombre+'  no fue borrado ya que esta siendo utilizado por un producto',
                       icon: "error"
                     });
                    buscar_pre();
                 }
               })
   
           } else if (result.dismiss === Swal.DismissReason.cancel) {
             swalWithBootstrapButtons.fire({
               title: "Cancelado",
               text: 'El Tipo '+nombre+'  no fue borrado :)',
               icon: "error"
             });
            buscar_pre();
           }
         });          
       })
       //Modificar presentacion
   
       $(document).on('click','.editar-pre',(e)=>{
           const elemento = $(this)[0].activeElement.parentElement.parentElement;
           const id = $(elemento).attr('preId');// con esto obtengo el Id
           const nombre = $(elemento).attr('preNombre');// con esto obtengo nombre
         $('#id_editar_pre').val(id);
         $('#nombre-presentacion').val(nombre);
         edit=true;
       })
   });