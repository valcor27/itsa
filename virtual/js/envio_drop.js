var myDropzone;

$(function(){
    // Inicializa Dropzone
    Dropzone.autoDiscover = false;
    myDropzone = new Dropzone("#my-dropzone", {
        autoProcessQueue: false,
        uploadMultiple: true,
        url: "php/documento_ssa/registro.php", // Reemplaza "tu_url_de_carga.php" con la URL real para manejar la carga de archivos
        paramName: "archivo", // Nombre del campo de archivo en tu formulario
        maxFilesize: 5, // Tamaño máximo de archivo en MB
        maxFiles: 1, // Número máximo de archivos permitidos
        acceptedFiles: ".docx, .xlsx, .pdf", // Tipos de archivo permitidos
        addRemoveLinks: true, // Agregar enlaces para eliminar archivos
        dictDefaultMessage: "Arrastra tu archivo aquí o haz clic para cargarlo",
        dictRemoveFile: "Eliminar archivo",
    });
});
myDropzone.on("sending", function (file, xhr, formData){
    // Evitar que Dropzone envíe automáticamente el formulario
    file.preventDefault();
});

/**------------------------Funcion Registrar Documento SSA----------------- */
function Registrar_documento_ssa(){
    // Obtener el formulario y crear un objeto FormData
    var formData = new FormData($("#form_documento")[0]);
    myDropzone.processQueue();
    // Agregar el proceso_documento a los datos
    //formData.append("proceso_documento", $("#proceso_documento").val());

    $.ajax({
        type:'POST',
        url:$('#form_documento').attr('action'),
        data: formData, // Usar el objeto FormData en lugar de serializar
        processData: false, // No procesar los datos
        contentType: false, // No establecer el tipo de contenido
        
        success:function(data){
            var array = JSON.parse(data);
            var comprobar = array[0];
            if($('#proceso_documento').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_documento').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Agregado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    Pagination_documentos(1);
                    return false;
                }else{
                    $('#alert_error_documento').show();
                }
            }else{
                if(comprobar == 0){
                    $('#modal_documento').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Actualizado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    Pagination_documentos(1);
                    return false;
                }else{
                    $('#alert_error_documento').show();
                }
            }
        }
    });
    return false;
};