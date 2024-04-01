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
            console.log(response);
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
});