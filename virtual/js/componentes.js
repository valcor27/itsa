
/*Funcion para abrir el modal de inicio de sesión */
function Modal_iniciar_sesion(){
    $('#formulario_sesion')[0].reset();
    $('#error_sesion').hide();
    $('#validar_sesion').hide();
    $('#info_sesion').show();
    $('#modallogin').modal('show');
    return false;
};
/**----------------------------------------------- */
/**Funcion para iniciar sesion --------------------*/
function Inicio_sesion(){
    var url = $('#url_inicio_sesion').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: $('#formulario_sesion').serialize(),
        beforeSend: function(){
            $('#validar_sesion').show();
            $('#error_sesion').hide();
        },
        success: function(respuesta){
            var acceso = respuesta;
            if(acceso == '0'){
                $('#validar_sesion').hide();
                $('#error_sesion').show();
                $('#formulario_sesion')[0].reset();
            }else{
                window.location.href = acceso;
                return false;
            }
        }
    });
    return false;
};
/**----------------------------------------------- */
/**----------Validación de sesiones activas--------------------- */
function Sesion_activa(bandera){
    var url = $('#url_sesion').val();
    $.ajax({
        type:'POST',
        url:url,
        data: {bandera:bandera},
        success:function(respuesta_sesion){
            var array = eval(respuesta_sesion);
            var intruso = array[1];
            if(intruso==1){
                window.location.href='../index.php';
                return false;
            }else{
                $('#datos_sesion').html(array[0]);
                return false;
            }
        }
    });
    return false;
};
/**----------------------------------------------- */
/**---------------------Funcion para cerrar sesion----------------- */
function Logout(id){
    var url = $('#url_logout').val();
    $.ajax({
        type:'POST',
        url:url,
        data:{id:id},
        success:function(data){
            window.location.href = '../index.php';
            return false;        
        }
    });
    return false;
};
/**----------------------------------------------- */
/*-----------Registrar/Actualizar pass o email sesion de usuario-------------*/
function Registrar_sesion_configuracion(){
    $.ajax({
        type: 'POST',
        url: $('#form_configuracion_sesion').attr('action'),
        data: $('#form_configuracion_sesion').serialize(),
        success:function(data){
            $('#modal_sesion_configuracion').modal('toggle');
            swal({
                title: 'Proceso Terminado',
                text: 'Registro Modificado Correctamente',
                type: 'success',
                showConfirmButton: false,
                timer: 1500
            })
            return false;
        }
    });
    return false;
};
/**----------------------------------------------- */
/**----------Mostrar los datos de sesion el usuario activo------- */
function Modificar_sesion_configuracion(id){
    $('#form_configuracion_sesion')[0].reset();
    var url = $('#url_modificar_sesion_configuracion').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id='+id,
        success:function(data){
            var cachetonypolar = eval(data);
            $('#pro_sesion').val('Edicion');
            $('#id_sesion').val(cachetonypolar[0]);
            $('#expediente_sesion').val(cachetonypolar[0]);
            $('#nom_usuario_sesion').val(cachetonypolar[1]);
            $('#contrasena_sesion').val(cachetonypolar[2]);
            $('#nivel_sesion').val(cachetonypolar[3]);
            $('#uareal').val(cachetonypolar[4]);
            $('#modal_sesion_configuracion_label').html("Configuración del Usuario");
            $('#modal_sesion_configuracion').modal('show');
            return false;
        }
    });
    return false;
};
/**---------------------------------------------------------------*/
/*---------------Modal para dar de alta a usuarios---------*/
function Modal_configuracion_usuarios(){
    $('#form_usuarios_ssa')[0].reset();
    $('#btn_agregar_usuario').show();
    $('#btn_actualizar_usuario').hide();
    $('#proceso').val('Registro');
    $('#alert_error').hide();
    $('#alert_sugerencia').hide();
    $('#modal_usuarios_ssa_label').html("Agregar Nuevo Usuario");
    $('#modal_usuarios_ssa').modal('show');

    return false;
};
/**------------------------------------------------------- */
/**------------Paginacion de Usuarios para SSA---- */
function Pagination_usuarios(partida){
    var url = $('#url_paginar').val();
    var dato = $('#busqueda').val();
    var ideliminar = '0';
    $.ajax({
        type:'POST',
        url:url,
        data:{ideliminar: ideliminar, dato:dato, partida:partida},
        success:function(data){
            var array = eval(data);
            $('#agrega-registros').html(array[0]);
            $('#pagination_info').html(array[1]);
            $('#pagination').html(array[2]);
            $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
            return false;
        }        
    });
    return false;
};
/**----------------------------------------------- */
/**----------------Registrar usuarios SSA-------------- */
function Registrar_usuarios_ssa(){
    $.ajax({
        type:'POST',
        url:$('#form_usuarios_ssa').attr('action'),
        data:$('#form_usuarios_ssa').serialize(),
        success:function(data){
            var array = eval(data);
            var comprobar = array[3];
            if($('#proceso').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_usuarios_ssa').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Agregado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    return false;
                }else{
                    $('#alert_error').show();
                }
            }else{
                if(comprobar == 0){
                    $('#modal_usuarios_ssa').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Actualizado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    return false;
                }else{
                    $('#alert_error').show();
                }
            }
        }
    });
    return false;
};
/**----------------------------------------------- */
/**--------------------Funcion para ver la informacion del usuario--------------------------- */
function Informacion_usuarios(id){
    $('#form_usuarios_ss_v')[0].reset();
    var url = $('#url_ver').val();
    $.ajax({
        type:'POST',
        url:url,
        data:'id='+id,
        success:function(valores){
            var datos = eval(valores);
            $('#expediente_v').val(datos[0]);
            $('#nom_usuario_v').val(datos[1]); 
            $('#sexo_v').val(datos[2]);
            $('#fNaci_v').val(datos[3]);
            $('#rfc_usuario_v').val(datos[4]);
            $('#curp_usuario_v').val(datos[5]);
            $('#cel_usuario_v').val(datos[6]);
            $('#emailp_usuario_v').val(datos[7]);
            $('#emaili_usuario_v').val(datos[8]);
            $('#fAlta_v').val(datos[9]);
            $('#c_plaza_v').val(datos[10]);
            $('#n_plaza_v').val(datos[11]);
            $('#uaReal').val(datos[13]);
            $('#uaReportada').val(datos[12]);
            $('#modal_usuarios_ssa_v_label').html("Ver Datos del Usuario");
            $('#modal_usuarios_ssa_v').modal('show');
            return false;
        }
    });
    return false;
};
/**----------------------------------------------- */
/**--------------------Funcion para actualizar los datos del usuario--------------------------- */
function Actualizar_usuarios(id){
    $('#form_usuarios_ssa')[0].reset();
    $('#alert_error').hide();
    $('#alert_sugerencia').hide();
    var url = $('#url_modificar').val();
    $.ajax({
        type:'POST',
        url:url,
        data:'id='+id,
        success:function(valores){
            var datos = eval(valores);
            $('#btn_agregar_usuario').hide();
            $('#btn_actualizar_usuario').show();
            $('#proceso').val('Edicion');
            $('#expediente').val(datos[0]);
            $('#primer_apellido').val(datos[1]); 
            $('#segundo_apellido').val(datos[2]);
            $('#nom_usuario').val(datos[3]);
            $('#sexo_usuario').val(datos[4]).change();
            $('#fNaci').val(datos[5]);
            $('#rfc_usuario').val(datos[6]);
            $('#curp_usuario').val(datos[7]);
            $('#contrasena_usuario').val(datos[8]);
            $('#cel_usuario').val(datos[9]);
            $('#emailp_usuario').val(datos[10]);
            $('#emaili_usuario').val(datos[11]);
            $('#fAlta').val(datos[12]);
            $('#nivel_usuario').val(datos[13]).change();
            $('#plaza_usuario').val(datos[14]).change();
            $('#unidadReportada_usuario').val(datos[15]).change();
            $('#unidadReal_usuario').val(datos[16]).change();
            $('#modal_usuarios_ssa_label').html("Modificar Usuario");
            $('#modal_usuarios_ssa').modal('show');
            return false;
        }
    });
    return false;
};
/**----------------------------------------------- */
/**--------------------Funcion para eliminar a un usuario--------------------------- */
function Eliminar_usuarios(ideliminar){
    var url = $('#url_paginar').val();
    var dato = '';
    var partida = '1';

    swal({
        title: "Eliminar Registro?",
        text: "El registro se eliminara de forma permanente!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Confirmar!",
        closeOnConfirm: false,
        closeOnCancel: false,
        cancelButtonText: "Cancelar"
    },

    function(isConfirm){
        if (isConfirm) {

           $.ajax({
            type:'POST',
            url:url,
            data: {ideliminar: ideliminar, dato: dato, partida: partida},
            success:function(data){
                var array = eval(data);

                $('#agrega-registros').html(array[0]);
                $('#pagination_info').html(array[1]);
                $('#pagination').html(array[2]);
                swal({
                    title: 'Proceso Terminado',
                    text: 'Registro Eliminado con Éxito',
                    type: 'success',
                    showConfirmButton: false,
                    timer: 1500
                })
                return false;
            }
        });    

       }else{
        swal("Proceso Cancelado", "No se ha efectuado ningún cambio.", "error");
    }
});
    return false;
};
/**----------------------------------------------- */
/**---------------------Modal Domicilio a usuarios---------------------- */
function Modal_configuracion_domicilio_usuarios(id){
    $('#form_domicilio')[0].reset();
    $('#btn_agregar_domicilio').show();
    $('#btn_actualizar_domicilio').hide();
    $('#proceso_domicilio').val('Registro');
    $('#alert_error_dom').hide();
    $('#id_domicilio_usuario').val(id);
    $('#municipio').find('option').remove().end().append('<option value="">Selecciona</option>');
    $('#modal_domicilio_label').html("Agregar Domicilio al Usuario");
    $('#modal_domicilio').modal('show');
    return false;
};
/**----------------------------------------------- ------------------------*/
/**--------Paginacion de divisiones del ITSA para un select ---------------*/
function Pagination_divisiones_select(partida){
    var url = $('#url_buscar_division').val();
    $.ajax({
        type: 'POST',
        url:url,
        data:{partida:partida},
        success:function(data){
            var datos = JSON.parse(data);
            $('#division').html(datos[0]);
            $('#division_materia').html(datos[0]);
            return false;
        }
    });
    return false;
};
/**----------------------------------------------- ------------------------*/
/**--------Paginacion de departamentos del ITSA para un select ------------*/
function Pagination_departamentos_select(partida){
    var url = $('#url_departamento').val();
    $.ajax({
        type: 'POST',
        url:url,
        data:{partida:partida},
        success:function(data){
            var datos = eval(data);
            //$('#departamento').html(datos[0]);
            $('#departamento_envio').html(datos[0]);
            return false;
        }
    });
    return false;
};
/**----------------------------------------------- ------------------------*/
/***----------------Paginacion para los diferentes tipos de departamentos en el alta o modificacion del documento */
function Pagination_departamentos_alta_select(){
    var url = $('#url_departamento_alta').val();
    var tipo_doc = $('#tipo_doc').val();
    var valor_departamento = $('#valor_departamento').val();
    $.ajax({
        type:'POST',
        url:url,
        data:{tipo_doc:tipo_doc, valor_departamento:valor_departamento},
        success:function(data){
            var jsp = JSON.parse(data);
            $('#departamento').html(jsp[0]);
        }
    });
};
/**-------------------------------------------------------------------------------------------------------------- */
/**-----------------------Paginacion de estados---------------- ------------------------*/
function Pagination_estado(partida){
    var url = $('#url_estado').val();
    $.ajax({
        type: 'POST',
        url:url,
        data:{partida:partida},
        success:function(data){
            var datos = eval(data);
            $('#estado').html(datos[0]);
            return false;
        }
    });
    return false;
};
/**----------------------------------------------- ------------------------*/
/**--------------------Paginacion de plaza para usuarios------------------ */
function Pagination_plaza(partida){
    var url = $('#url_paginacion_plaza').val();
    $.ajax({
        type: 'POST',
        url:url,
        data:{partida:partida},
        success:function(data){
            var array = JSON.parse(data);
            $('#plaza_usuario').html(array[0]);
            return false;
        }
    });
    return false;
};
/**----------------------------------------------------------------------- */
/**---------------------------Paginacion de municipios ------------------------*/
function Pagination_municipios(){
    var url = $('#url_municipio').val();
    var estado = $('#estado').val();
    var idmuni = $('#valor_municipio').val();
    $.ajax({
        type:'POST',
        url:url,
        data:{estado:estado, idmuni:idmuni},
        success:function(data){
            var valcor = eval(data);
            $('#municipio').html(valcor[0]);
            return false;
        }
    });
    return false;
};
/**----------------------------------------------- ------------------------*/
/**---------------------Paginacion de buscar edificio--------------------- */
function Pagination_buscar_edificio(partida){
    var url = $('#url_buscar_edificio').val();
    $.ajax({
        type: 'POST',
        url:url,
        data:{partida:partida},
        success:function(data){
            var datos = JSON.parse(data);
            $('#edificio').html(datos[0]);
            return false;
        }
    });
    return false;
};
/**----------------------------------------------- ------------------------*/
/**---------------------registrar domicilio a usuarios---------------------- */
function Registrar_domicilio_usuarios(){
    $.ajax({
        type:'POST',
        url:$('#form_domicilio').attr('action'),
        data:$('#form_domicilio').serialize(),
        success:function(data){
            var array = eval(data);
            var comprobar = array[0];
            if($('#proceso').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_domicilio').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Agregado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    Pagination_usuarios(1);
                    return false;
                }else{
                    $('#alert_error').show();
                }
            }else{
                if(comprobar == 0){
                    $('#modal_domicilio').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Actualizado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    Pagination_usuarios(1);
                    return false;
                }else{
                    $('#alert_error').show();
                }
            }
        }
    });
    return false;
};
/**----------------------------------------------- ------------------------*/
/**---------------------actualizar Domicilio a usuarios---------------------- */
function Actualizar_domicilio_usuario(id, domicilio){
    $('#form_domicilio')[0].reset();
    var url = $('#url_modificar_domicilio').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: {id:id, domicilio:domicilio},
        success:function(data){
            var cachetonypolar = eval(data);
            $('#proceso_domicilio').val('Edicion');
            $('#id_domicilio').val(cachetonypolar[0]);
            $('#id_domicilio_usuario').val(cachetonypolar[1]);
            $('#calle').val(cachetonypolar[2]);
            $('#next').val(cachetonypolar[3]);
            $('#nint').val(cachetonypolar[4]);
            $('#col').val(cachetonypolar[5]);
            $('#cpostal').val(cachetonypolar[6]);
            $('#local').val(cachetonypolar[7]);
            //$('#municipio').val(cachetonypolar[9]).change();
            $('#valor_municipio').val(cachetonypolar[9]);
            if($('#estado').val(cachetonypolar[8]).change()){
                $('#valor_municipio').val('0');
            }
            $('#btn_agregar_domicilio').hide();
            $('#btn_actualizar_domicilio').show();
            $('#modal_domicilio_label').html("Actulizar Domicilio");
            $('#modal_domicilio').modal('show');
            return false;
        }
    });
    return false;
};
/**----------------------------------------------- ------------------------*/
/*-------------------------Paginar Documentos SSA---------------------------*/
function Pagination_documentos(partida){
    var url = $('#url_paginar').val();
    var dato = $('#busqueda').val();
    var ideliminar = '0';
    var idaceptar = '0';

    $.ajax({
        type:'POST',
        url:url,
        data:{ideliminar: ideliminar, dato:dato, partida:partida, idaceptar:idaceptar},
        success:function(data){
            var array = eval(data);
            $('#agrega-registros').html(array[0]);
            $('#pagination_info').html(array[1]);
            $('#pagination').html(array[2]);
            $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
            return false;
        }        
    });
    return false;
};
/**-------------------------------------------------------------------------*/
/**-------------------------Modal documentos SSA--------------------------- */
function Modal_configuracion_documentos(){
    $('#form_documento')[0].reset();
    $('#fuente_fin').selectpicker('deselectAll');
    $('#btn_agregar_documento').text("Registrar");
    $('#proceso_documento').val('Registro');
    $('#alert_error_documento').hide();
    $('#departamento').find('option').remove().end().append('<option value="">Selecciona</option>');
    $('#modal_documento_label').html("Agregar Nuevo Documento");
    $('#modal_documento').modal('show');
    return false;
};
/**------------------------------------------------------------------------ */
/**-----------------------Paginacion de inputs para partida---------------- */
function Pagination_inputs() {
    var ff = $('#fuente_fin').val();

    // Restaurar todos los campos de entrada primero (por si acaso)
    $('#pcd, #pf, #pe, #pip, #ppa').prop('disabled', false);
    $('.columna_partida').hide();

    // Verificar la selección y mostrar/habilitar campos de entrada según corresponda
    if (ff.indexOf('141') !== -1) {
        $('#pcd').prop('disabled', false);
        $('#partida_cderechos').show();
    }
    if (ff.indexOf('151') !== -1) {
        $('#pf').prop('disabled', false);
        $('#partida_federal').show();
    }
    if (ff.indexOf('161') !== -1) {
        $('#pe').prop('disabled', false);
        $('#partida_estatal').show();
    }
    if (ff.indexOf('145') !== -1) {
        $('#pip').prop('disabled', false);
        $('#partida_ipropios').show();
    }
    if (ff.indexOf('07') !== -1) {
        $('#ppa').prop('disabled', false);
        $('#partida_pasignar').show();
    }

    return false;
}

/**------------------------------------------------------------------------ */
/***------------------------Agregar documentos----------------------------- */
function Registrar_documento_ssa(){
    //e.preventDefault(); //evita el envio tradicional del formulario
    console.log("formulario enviandose");
    var formData = new FormData($("#form_documento")[0]);
    /*formData.append("proceso_documento", $("#proceso_documento").val());
    formData.append("id_documento", $("#id_documento").val());
    formData.append("folio", $("#folio").val());
    formData.append("asunto", $("#asunto").val());
    formData.append("departamento", $("#departamento").val());
    formData.append("fCrea", $("#fCrea").val());
    formData.append("tipo_doc", $("#tipo_doc").val());
    formData.append("fuente_fin", $("#fuente_fin").val());
    formData.append("pcd", $("#pcd").val());
    formData.append("pf", $("#pf").val());
    formData.append("pe", $("#pe").val());
    formData.append("pip", $("#pip").val());
    formData.append("observacion", $("#observacion").val());
    formData.append("archivo", $("#archivo").val());*/
    $.ajax({
        type: 'POST',
        url: $('#form_documento').attr('action'),
        data: formData,
        processData: false,
        contentType: false,
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
                }else if(comprobar == 2){
                    swal({
                        title: 'Incorrecto',
                        text: 'Por favor, eliga un documento PDF',
                        type: 'error',
                        showConfirmButton: true
                    })
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
                }else if(comprobar == 2){
                    swal({
                        title: 'Incorrecto',
                        text: 'Por favor, eliga un documento PDF',
                        type: 'error',
                        showConfirmButton: true
                    })
                    return false;
                }else{
                    $('#alert_error_documento').show();
                }
            }
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-----------------------Actualizar documentos---------------------------- */
function Actualizar_documento(id){
    $('#form_documento')[0].reset();
    var url = $('#url_modificar').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: {id:id},
        success:function(data){
            var cachetonypolar = JSON.parse(data);
            $('#proceso_documento').val('Edicion');
            $('#id_documento').val(cachetonypolar[0]);
            $('#folio').val(cachetonypolar[1]);
            $('#asunto').val(cachetonypolar[10]);
            //$('#departamento').val(cachetonypolar[2]);
            $('#fCrea').val(cachetonypolar[3]);
            $('#valor_departamento').val(cachetonypolar[2]);
            if($('#tipo_doc').val(cachetonypolar[4]).change()){
                $('#valor_departamento').val('0');
            }
            //$('#tipo_doc').val(cachetonypolar[4]);
            //$('#fuente_fin').empty();
            //$('#fuente_fin').selectpicker('deselectAll');
            //$('#fuente_fin').val(cachetonypolar[5]).change();
            $('#fuente_fin').selectpicker('val', cachetonypolar[5]);
            /*$.each(cachetonypolar[5].split(","), function(i, e) {
                $("#fuente_fin option[value='" + e + "']").prop("selected", true);
            });*/
            //$('#fuente_fin').selectpicker('refresh');
            $('#pcd').val(cachetonypolar[6]);
            $('#pf').val(cachetonypolar[7]);
            $('#pe').val(cachetonypolar[8]);
            $('#pip').val(cachetonypolar[9]);
            $('#ppa').val(cachetonypolar[12]);
            $('#observacion').val(cachetonypolar[11]);
            //$('#archivo').val(cachetonypolar[12]);
            $('#alert_error_documento').hide();
            $('#btn_agregar_documento').text("Actualizar");
            Pagination_inputs();
            $('#modal_documento_label').html("Actulizar Documento");
            $('#modal_documento').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-------------------------Eliminar documentos---------------------------- */
function Eliminar_documento(ideliminar){
    var url = $('#url_paginar').val();
    var dato = '';
    var partida = '1';
    var idaceptar = '';

    swal({
        title: "Cancelar Documento?",
        text: "El registro se cancelara de forma permanente!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Confirmar!",
        closeOnConfirm: false,
        closeOnCancel: false,
        cancelButtonText: "Cancelar"
    },

    function(isConfirm){
        if (isConfirm) {

           $.ajax({
                type:'POST',
                url:url,
                data: {ideliminar: ideliminar, dato: dato, partida: partida, idaceptar:idaceptar},
                success:function(data){
                    var array = eval(data);

                    $('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Cancelado con Éxito',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    return false;
                }
            });    

        }else{
            swal("Proceso Cancelado", "No se ha efectuado ningún cambio.", "error");
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**---------------------------Aceptar documentos--------------------------- */
function Aceptar_documento(idaceptar){
        var url = $('#url_paginar').val();
        var dato = '';
        var partida = '1';
        var ideliminar = '';
    
        swal({
            title: "Aceptar Documento?",
            text: "El documento se aceptara de forma permanente!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#157347",
            confirmButtonText: "Confirmar!",
            closeOnConfirm: false,
            closeOnCancel: false,
            cancelButtonText: "Cancelar"
        },
    
        function(isConfirm){
            if (isConfirm) {
    
               $.ajax({
                    type:'POST',
                    url:url,
                    data: {ideliminar: ideliminar, dato: dato, partida: partida, idaceptar:idaceptar},
                    success:function(data){
                        var array = eval(data);
    
                        $('#agrega-registros').html(array[0]);
                        $('#pagination_info').html(array[1]);
                        $('#pagination').html(array[2]);
                        $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                        swal({
                            title: 'Proceso Terminado',
                            text: 'Registro Aceptado con Éxito',
                            type: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        return false;
                    }
                });    
    
            }else{
                swal("Proceso Cancelado", "No se ha efectuado ningún cambio.", "error");
            }
        });
    return false;
};
/**------------------------------------------------------------------------ */
/**---------------------------modal del envio de documentos---------------------------- */
function Enviar_documento(id){
    $('#form_documento_envio')[0].reset();
    var url = $('#url_documento_envio').val();
    $.ajax({
        type: 'POST',
        url: url,
        data:{id:id},
        success:function(data){
            var josan = JSON.parse(data);
            $('#proceso_documento_envio').val("Registro");
            $('#id_documento_envio').val(josan[0]);
            $('#fecha_envio_documento').val(josan[3]);
            $('#folio_envio').val(josan[1]);
            $('#asunto_envio').val(josan[2]);
            $('#fEnv').val(josan[3]);
            $('#btn_agregar_documento_envio').show();
            $('#alert_error_documento_envio').hide();
            $('#modal_documento_envio_label').html("Realizar Envio");
            $('#modal_documento_envio').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**---------------------------Enviar documentos --------------------------- */
function Registrar_documento_envio_ssa(){
    $.ajax({
        type:'POST',
        url:$('#form_documento_envio').attr('action'),
        data:$('#form_documento_envio').serialize(),
        success:function(data){
            var array = JSON.parse(data);
            var comprobar = array[0];
            if($('#proceso_documento_envio').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_documento_envio').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Documento Enviado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }else{
                    $('#alert_error_documento_envio').show();
                }
            }
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**---------------------------Historial documentos---------------------------- */
function Historial_documento(id){
    var url = $('#url_historial_documento').val();
    $.ajax({
        type: 'POST',
        url: url,
        data:{id:id},
        success:function(data){
            var valcor = JSON.parse(data);
            $('#historial_documentos_table').html(valcor[0]);
            $('#modal_historial_documento_label').html("Historial de Movimientos");
            $('#modal_historial_documento').modal('show');
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**----------------Paginacion Edificios------------------------------------ */
function Pagination_edificios(partida){
    var url = $('#url_paginar').val();
    var dato = $('#busqueda').val();
    var ideliminar = '0';
    $.ajax({
        type:'POST',
        url:url,
        data:{ideliminar: ideliminar, dato:dato, partida:partida},
        success:function(data){
            var array = eval(data);
            $('#agrega-registros').html(array[0]);
            $('#pagination_info').html(array[1]);
            $('#pagination').html(array[2]);
            $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
            return false;
        }        
    });
    return false;
};
/**------------------------------------------------------------------------ */
/***--------------------Funcion para abrir modal de edificio--------------- */
function Modal_configuracion_edificio(){
    $('#form_edificio')[0].reset();
    $('#btn_agregar_edificio').show();
    $('#btn_actualizar_edificio').hide();
    $('#proceso_edificio').val('Registro');
    $('#alert_error').hide();
    $('#modal_edificio_label').html("Agregar Nuevo Edificio");
    $('#modal_edificio').modal('show');
    return false;
};
/**------------------------------------------------------------------------ */
/**------------------Funcion para registrar edificio----------------------- */
function Registrar_edificio(){
    $.ajax({
        type:'POST',
        url:$('#form_edificio').attr('action'),
        data:$('#form_edificio').serialize(),
        success:function(data){
            var array = eval(data);
            var comprobar = array[3];
            if($('#proceso_edificio').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_edificio').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Agregado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    return false;
                }else{
                    $('#alert_error').show();
                }
            }else{
                if(comprobar == 0){
                    $('#modal_edificio').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Actualizado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    return false;
                }else{
                    $('#alert_error').show();
                }
            }
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-----------------Funcion para actualizar el edificio-------------------- */
function Actualizar_edificio(id){
    $('#form_edificio')[0].reset();
    var url = $('#url_modificar').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: {id:id},
        success:function(data){
            var cachetonypolar = JSON.parse(data);
            $('#proceso_edificio').val('Edicion');
            $('#id_edificio').val(cachetonypolar[0]);
            $('#nombre').val(cachetonypolar[1]);
            $('#alert_error').hide();
            $('#btn_agregar_edificio').hide();
            $('#btn_actualizar_edificio').show();
            $('#modal_edificio_label').html("Actulizar Edificio");
            $('#modal_edificio').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-----------------Funcion para eliminar el edificio---------------------- */
function Eliminar_edificio(ideliminar){
    var url = $('#url_paginar').val();
    var dato = '';
    var partida = '1';

    swal({
        title: "Eliminar Edificio?",
        text: "El registro se eliminara de forma permanente!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Confirmar!",
        closeOnConfirm: false,
        closeOnCancel: false,
        cancelButtonText: "Cancelar"
    },

    function(isConfirm){
        if (isConfirm) {

           $.ajax({
                type:'POST',
                url:url,
                data: {ideliminar: ideliminar, dato: dato, partida: partida},
                success:function(data){
                    var array = eval(data);

                    $('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Eliminado con Éxito',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    return false;
                }
            });    

        }else{
            swal("Proceso Cancelado", "No se ha efectuado ningún cambio.", "error");
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**----------------Paginacion Salon------------------------------------ */
function Pagination_salon(partida){
    var url = $('#url_paginar').val();
    var dato = $('#busqueda').val();
    var ideliminar = '0';
    $.ajax({
        type:'POST',
        url:url,
        data:{ideliminar: ideliminar, dato:dato, partida:partida},
        success:function(data){
            var array = eval(data);
            $('#agrega-registros').html(array[0]);
            $('#pagination_info').html(array[1]);
            $('#pagination').html(array[2]);
            $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
            return false;
        }        
    });
    return false;
};
/**------------------------------------------------------------------------ */
/***--------------------Funcion para abrir modal de salon--------------- */
function Modal_configuracion_salon(){
    $('#form_salon')[0].reset();
    $('#btn_agregar_salon').show();
    $('#btn_actualizar_salon').hide();
    $('#proceso_salon').val('Registro');
    $('#alert_error').hide();
    $('#modal_salon_label').html("Agregar Nuevo Salón");
    $('#modal_salon').modal('show');
    return false;
};
/**------------------------------------------------------------------------ */
/**------------------Funcion para registrar salon----------------------- */
function Registrar_salon(){
    $.ajax({
        type:'POST',
        url:$('#form_salon').attr('action'),
        data:$('#form_salon').serialize(),
        success:function(data){
            var array = eval(data);
            var comprobar = array[3];
            if($('#proceso_salon').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_salon').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Agregado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    return false;
                }else{
                    $('#alert_error').show();
                }
            }else{
                if(comprobar == 0){
                    $('#modal_salon').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Actualizado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    return false;
                }else{
                    $('#alert_error').show();
                }
            }
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-----------------Funcion para actualizar el salon-------------------- */
function Actualizar_salon(id){
    $('#form_salon')[0].reset();
    var url = $('#url_modificar').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: {id:id},
        success:function(data){
            var cachetonypolar = JSON.parse(data);
            $('#proceso_salon').val('Edicion');
            $('#id_salon').val(cachetonypolar[0]);
            $('#nombre').val(cachetonypolar[1]);
            $('#edificio').val(cachetonypolar[2]).change();
            $('#alert_error').hide();
            $('#btn_agregar_salon').hide();
            $('#btn_actualizar_salon').show();
            $('#modal_salon_label').html("Actulizar Salón");
            $('#modal_salon').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-----------------Funcion para eliminar el salon---------------------- */
function Eliminar_salon(ideliminar){
    var url = $('#url_paginar').val();
    var dato = '';
    var partida = '1';

    swal({
        title: "Eliminar Salón?",
        text: "El registro se eliminara de forma permanente!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Confirmar!",
        closeOnConfirm: false,
        closeOnCancel: false,
        cancelButtonText: "Cancelar"
    },

    function(isConfirm){
        if (isConfirm) {

           $.ajax({
                type:'POST',
                url:url,
                data: {ideliminar: ideliminar, dato: dato, partida: partida},
                success:function(data){
                    var array = eval(data);

                    $('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Eliminado con Éxito',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    return false;
                }
            });    

        }else{
            swal("Proceso Cancelado", "No se ha efectuado ningún cambio.", "error");
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-----------------------funcion para paginacion de grupos---------------- */
function Pagination_grupo(partida){
    var url = $('#url_paginar').val();
    var dato = $('#busqueda').val();
    var ideliminar = '0';
    $.ajax({
        type:'POST',
        url:url,
        data:{ideliminar: ideliminar, dato:dato, partida:partida},
        success:function(data){
            var array = eval(data);
            $('#agrega-registros').html(array[0]);
            $('#pagination_info').html(array[1]);
            $('#pagination').html(array[2]);
            $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
            return false;
        }        
    });
    return false;
};
/**------------------------------------------------------------------------ */
/***--------------------Funcion para abrir modal de grupos--------------- */
function Modal_configuracion_grupo(){
    $('#form_grupo')[0].reset();
    $('#btn_agregar_grupo').show();
    $('#btn_actualizar_grupo').hide();
    $('#proceso_grupo').val('Registro');
    $('#alert_error').hide();
    $('#modal_grupo_label').html("Agregar Nuevo Grupo");
    $('#modal_grupo').modal('show');
    return false;
};
/**------------------------------------------------------------------------ */
/**------------------Funcion para registrar grupos----------------------- */
function Registrar_grupo(){
    $.ajax({
        type:'POST',
        url:$('#form_grupo').attr('action'),
        data:$('#form_grupo').serialize(),
        success:function(data){
            var array = eval(data);
            var comprobar = array[3];
            if($('#proceso_grupo').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_grupo').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Agregado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    return false;
                }else{
                    $('#alert_error').show();
                }
            }else{
                if(comprobar == 0){
                    $('#modal_grupo').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Actualizado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    return false;
                }else{
                    $('#alert_error').show();
                }
            }
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-----------------Funcion para actualizar el grupo-------------------- */
function Actualizar_grupo(id){
    $('#form_grupo')[0].reset();
    var url = $('#url_modificar').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: {id:id},
        success:function(data){
            var cachetonypolar = JSON.parse(data);
            $('#proceso_grupo').val('Edicion');
            $('#id_grupo').val(cachetonypolar[0]);
            $('#nombre').val(cachetonypolar[1]);
            $('#division').val(cachetonypolar[2]).change();
            $('#alert_error').hide();
            $('#btn_agregar_grupo').hide();
            $('#btn_actualizar_grupo').show();
            $('#modal_grupo_label').html("Actulizar Grupo");
            $('#modal_grupo').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-----------------Funcion para eliminar el grupo---------------------- */
function Eliminar_grupo(ideliminar){
    var url = $('#url_paginar').val();
    var dato = '';
    var partida = '1';

    swal({
        title: "Eliminar Grupo?",
        text: "El registro se eliminara de forma permanente!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Confirmar!",
        closeOnConfirm: false,
        closeOnCancel: false,
        cancelButtonText: "Cancelar"
    },

    function(isConfirm){
        if (isConfirm) {

           $.ajax({
                type:'POST',
                url:url,
                data: {ideliminar: ideliminar, dato: dato, partida: partida},
                success:function(data){
                    var array = eval(data);

                    $('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Eliminado con Éxito',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    return false;
                }
            });    

        }else{
            swal("Proceso Cancelado", "No se ha efectuado ningún cambio.", "error");
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-----------------------funcion para paginacion de materias---------------- */
function Pagination_materia(partida){
    var url = $('#url_paginar').val();
    var dato = $('#busqueda').val();
    var ideliminar = '0';
    $.ajax({
        type:'POST',
        url:url,
        data:{ideliminar: ideliminar, dato:dato, partida:partida},
        success:function(data){
            var array = eval(data);
            $('#agrega-registros').html(array[0]);
            $('#pagination_info').html(array[1]);
            $('#pagination').html(array[2]);
            $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
            return false;
        }        
    });
    return false;
};
/**------------------------------------------------------------------------ */
/***--------------------Funcion para abrir modal de materia--------------- */
function Modal_configuracion_materia(){
    $('#form_materia')[0].reset();
    $('#btn_agregar_materia').show();
    $('#btn_actualizar_materia').hide();
    $('#proceso_materia').val('Registro');
    $('#alert_error').hide();
    $('#modal_materia_label').html("Agregar Nueva Materia");
    $('#modal_materia').modal('show');
    return false;
};
/**------------------------------------------------------------------------ */
/**------------------Funcion para registrar materias----------------------- */
function Registrar_materia(){
    $.ajax({
        type:'POST',
        url:$('#form_materia').attr('action'),
        data:$('#form_materia').serialize(),
        success:function(data){
            var array = eval(data);
            var comprobar = array[3];
            if($('#proceso_materia').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_materia').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Agregado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    return false;
                }else{
                    $('#alert_error').show();
                }
            }else{
                if(comprobar == 0){
                    $('#modal_materia').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Actualizado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    return false;
                }else{
                    $('#alert_error').show();
                }
            }
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-----------------Funcion para actualizar la materia-------------------- */
function Actualizar_materia(id){
    $('#form_materia')[0].reset();
    var url = $('#url_modificar').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: {id:id},
        success:function(data){
            var cachetonypolar = JSON.parse(data);
            $('#proceso_materia').val('Edicion');
            $('#id_materia').val(cachetonypolar[0]);
            $('#nombre').val(cachetonypolar[1]);
            $('#division').val(cachetonypolar[2]).change();
            $('#alert_error').hide();
            $('#btn_agregar_materia').hide();
            $('#btn_actualizar_materia').show();
            $('#modal_materia_label').html("Actulizar Materia");
            $('#modal_materia').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-----------------Funcion para eliminar la materia---------------------- */
function Eliminar_materia(ideliminar){
    var url = $('#url_paginar').val();
    var dato = '';
    var partida = '1';

    swal({
        title: "Eliminar Grupo?",
        text: "El registro se eliminara de forma permanente!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Confirmar!",
        closeOnConfirm: false,
        closeOnCancel: false,
        cancelButtonText: "Cancelar"
    },

    function(isConfirm){
        if (isConfirm) {

           $.ajax({
                type:'POST',
                url:url,
                data: {ideliminar: ideliminar, dato: dato, partida: partida},
                success:function(data){
                    var array = eval(data);

                    $('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Eliminado con Éxito',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    return false;
                }
            });    

        }else{
            swal("Proceso Cancelado", "No se ha efectuado ningún cambio.", "error");
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**----------------------Paginacion docente-------------------------------- */
function Pagination_docente(partida){
    var url = $('#url_paginar').val();
    var dato = $('#busqueda').val();
    var ideliminar = '0';
    $.ajax({
        type:'POST',
        url:url,
        data:{ideliminar: ideliminar, dato:dato, partida:partida},
        success:function(data){
            var array = eval(data);
            $('#agrega-registros').html(array[0]);
            $('#pagination_info').html(array[1]);
            $('#pagination').html(array[2]);
            $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
            return false;
        }        
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-----------------------Funcion para mostrar el modal de docente--------- */
function Modal_configuracion_docente(){
    $('#form_docente')[0].reset();
    //$('#exp_doc').selectpicker('deselectAll');
    // Restablecer el selectpicker a su estado predeterminado
    $('#exp_doc').selectpicker('val', '');
    $('#btn_agregar_docente').show();
    $('#btn_actualizar_docente').hide();
    $('#proceso_docente').val('Registro');
    $('#alert_error').hide();
    $('#modal_docente_label').html("Agregar Nuevo Docente");
    $('#modal_docente').modal('show');
    return false;
};
/**------------------------------------------------------------------------ */
/***-------------------Registrar docente----------------------------------- */
function Registrar_docente(){
    $.ajax({
        type:'POST',
        url:$('#form_docente').attr('action'),
        data:$('#form_docente').serialize(),
        success:function(data){
            var array = eval(data);
            var comprobar = array[3];
            if($('#proceso_docente').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_docente').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Agregado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    return false;
                }else{
                    $('#alert_error').show();
                }
            }else{
                if(comprobar == 0){
                    $('#modal_docente').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Actualizado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    return false;
                }else{
                    $('#alert_error').show();
                }
            }
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**---------------------Buscar select docente------------------------------ */
function Pagination_select_docente(partida){
    var url = $('#url_buscar_docentes').val();
    $.ajax({
        type: 'POST',
        url:url,
        data:{partida:partida},
        success:function(data){
            var datos = JSON.parse(data);
            //$('#exp_doc').selectpicker('val', datos[0]);
            //$('#exp_doc').selectpicker('render');
            // Limpia y llena el selectpicker con los datos
            /*var expe_doc = $('#exp_doc');
            $.each(datos, function (index, optionData) {
                expe_doc.append($('<option>', {
                    value: optionData.id,
                    text: optionData.nombre_completo
                }));
            });*/

            // Actualiza el selectpicker
            
            $('#docente_select_docente').html(datos[0]);
            
            //$('#exp_doc').selectpicker('refresh');
            //$('.filter-option-inner-inner').html("Seleccione un Docente");
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**--------------------------Modificar Docente----------------------------- */
function Actualizar_docente(id){
    $('#form_docente')[0].reset();
    $('#exp_doc').selectpicker('val', '');
    var url = $('#url_modificar').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: {id:id},
        success:function(data){
            var cachetonypolar = JSON.parse(data);
            $('#proceso_docente').val('Edicion');
            $('#id_docente').val(cachetonypolar[0]);
            $('#exp_doc').selectpicker('val', cachetonypolar[1]);
            $('#clave_docente').val(cachetonypolar[2]);
            $('#alert_error').hide();
            $('#btn_agregar_docente').hide();
            $('#btn_actualizar_docente').show();
            $('#modal_docente_label').html("Actulizar Docente");
            $('#modal_docente').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**------------------------------Eliminar Docente-------------------------- */
function Eliminar_docente(ideliminar){
    var url = $('#url_paginar').val();
    var dato = '';
    var partida = '1';

    swal({
        title: "Eliminar Docente?",
        text: "El registro se eliminara de forma permanente!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Confirmar!",
        closeOnConfirm: false,
        closeOnCancel: false,
        cancelButtonText: "Cancelar"
    },

    function(isConfirm){
        if (isConfirm) {

           $.ajax({
                type:'POST',
                url:url,
                data: {ideliminar: ideliminar, dato: dato, partida: partida},
                success:function(data){
                    var array = eval(data);

                    $('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Eliminado con Éxito',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    return false;
                }
            });    

        }else{
            swal("Proceso Cancelado", "No se ha efectuado ningún cambio.", "error");
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-----------------------------Modal mostrar la educacion del docente----- */
function Modal_educacion_docente(id){
    var url = $('#url_estudios_docentes').val();
   /* var nom = $('#nom_docente').val();
    var exp = $('#exp_docente').val();
    var cla = $('#cla_docente').val();
    if($('#nom_docente').val() == 0 && $('#exp_docente').val() == 0 && $('#cla_docente').val() == 0){
        $('#datos_docente').hide();
    }else{
        $('#datos_docente').show();
    }*/
    $.ajax({
        type: 'POST',
        url: url,
        data:{id:id},
        success:function(data){
            var valcor = JSON.parse(data);
            $('#historial_estudios_docentes').html(valcor[0]);
            $('#nom_docente').val(valcor[1]);
            $('#exp_docente').val(valcor[3]);
            $('#cla_docente').val(valcor[2]);
            $('#id_docente_estudio').val(id);
            //$('#docentes_id_docentes').val(id);
            if($('#nom_docente').val() == 0 && $('#exp_docente').val() == 0 && $('#cla_docente').val() == 0){
                $('#datos_docente').hide();
            }else{
                $('#datos_docente').show();
            }
            $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
            $('#modal_estudio_docentes_label').html("Estudios Docente");
            $('#modal_estudios_docentes').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
function Modal_registro_estudio_docente(){
    $('#form_estudio_docente')[0].reset();
    $('#proceso_estudio_docente').val('Registro');
    $('#alert_error_estudios').hide();
    $('#btn_agregar_estudio_docente').show();
    $('#btn_actualizar_estudio_docente').hide();
    var docentes_id_docentes = $('#id_docente_estudio').val();
    $('#docentes_id_docentes').val(docentes_id_docentes);
    $('#modal_estudio_docente_label').html("Agregar Nuevo Estudio");
    $('#modal_estudios_docentes').modal('toggle');
    $('#modal_estudio_docente').modal('show');  
    return false;
};
/**---------------------------Registrar estudio del docente---------------- */
function Registrar_estudio_docente(){
    $.ajax({
        type:'POST',
        url:$('#form_estudio_docente').attr('action'),
        data:$('#form_estudio_docente').serialize(),
        success:function(data){
            var array = JSON.parse(data);
            var comprobar = array[0];
            var docente = array[1];
            if($('#proceso_estudio_docente').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_estudio_docente').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Agregado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    Modal_educacion_docente(docente);
                    return false;
                }else{
                    $('#alert_error_estudios').show();
                }
            }else{
                if(comprobar == 0){
                    $('#modal_estudio_docente').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Actualizado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    Modal_educacion_docente(docente);
                    return false;
                }else{
                    $('#alert_error_estudios').show();
                }
            }
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**---------------------------Actualizar estudio del docente--------------- */
function Actualizar_estudio_docente(id){
    $('#form_estudio_docente')[0].reset();
    var url = $('#url_modificar_estudios_docente').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: {id:id},
        success:function(data){
            var cachetonypolar = JSON.parse(data);
            $('#proceso_estudio_docente').val('Edicion');
            $('#id_docente_nivel_estudio').val(cachetonypolar[0]);
            $('#docentes_id_docentes').val(cachetonypolar[1]);
            $('#select_nivel_estudio').val(cachetonypolar[2]);
            $('#titulo').val(cachetonypolar[3]);
            $('#cedula').val(cachetonypolar[4]);
            $('#escuela').val(cachetonypolar[5]);
            $('#alert_error_estudios').hide();
            $('#btn_agregar_estudio_docente').hide();
            $('#btn_actualizar_estudio_docente').show();
            $('#modal_estudios_docentes').modal('toggle');
            $('#modal_estudio_docente_label').html("Actulizar Estudio");
            $('#modal_estudio_docente').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**------------------------Eliminar estudio del docente-------------------- */
function Eliminar_estudio_docente(id){
    var url = $('#url_eliminar_estudio_docente').val();
    //var dato = '';
    //var partida = '1';
    $('#modal_estudios_docentes').modal('toggle');
    swal({
        title: "Eliminar Estudio de Docente?",
        text: "El registro se eliminara de forma permanente!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Confirmar!",
        closeOnConfirm: false,
        closeOnCancel: false,
        cancelButtonText: "Cancelar"
    },

    function(isConfirm){
        if (isConfirm) {

           $.ajax({
                type:'POST',
                url:url,
                data: {id:id},
                success:function(data){
                    var array = JSON.parse(data);
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Eliminado con Éxito',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    Modal_educacion_docente(array[0]);
                    return false;
                }
            });    

        }else{
            swal("Proceso Cancelado", "No se ha efectuado ningún cambio.", "error");
            $('#modal_estudios_docentes').modal('show');
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */

/**------------------------------------Carga laboral del docente----------- */
/*var id_docente_carga;
function Carga_docente(id){
    $('#contenido_pagina').load('modulos/carga_docente.php');
    $('html, body').animate({scrollTop: 0}, 'slow');
    //$('#valor_docente').val(id);
    id_docente_carga = id;
    //Pagination_datos_docente(id);
    /*var url = $('#url_docente_carga_docente').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: {id:id},
        success:function(data){
            var corona = JSON.parse(data);
            //pendiente los datos del docente nombre expediente y clave
            $('#contenido_pagina').load('modulos/carga_docente.php');
            $('html, body').animate({scriollTop: 0}, 'slow');
            $('#nombre_docente').html(corona[3]);
            $('#expediente_doc').html(corona[1]);
            $('#clave_doc').html(corona[2]);
            return false;
        }
    });*/
    /*return false;
};*/
/**------------------------------------------------------------------------ */
/**----------------Pagination datos del docente---------------------------- */
/*function Pagination_datos_docente(){
    var url = $('#url_datos_docente').val();
    var id = id_docente_carga;
    $.ajax({
        type: 'POST',
        url: url, 
        data: {id,id},
        success:function(data){
            var corona = JSON.parse(data);
            $('#nombre_docente').html(corona[3]);
            $('#expediente_doc').html(corona[1]);
            $('#clave_doc').html(corona[2]);
            return false;
        }
    });
    return false;
};*/
/**------------------------------------------------------------------------ */
/**----------------Pagination Carga academica del docente------------------ */
/*function Pagination_carga_laboral(){
    var url = $('#url_carga_laboral').val();
    var id = id_docente_carga;
    $.ajax({
        type: 'POST',
        url: url,
        data: {id,id},
        success:function(data){
            var valle = JSON.parse(data);
            $('#tabla_carga').html(valle[0]);
            return false;
        }
    });
    return false;
};*/
/**------------------------------------------------------------------------ */
/***---------Cargar módulo con datos de la carga del docente--------------- */
function Examina_carga_individual(iddocente){
    $('#contenido_pagina').load("modulos/carga_docente.php", function Detalle_procesado(){
        var url = "php/carga/consulta_carga_docente.php";
        $.ajax({
            type:'POST',
            url:url,
            data:{iddocente: iddocente},
            success:function(data){
                var array = JSON.parse(data);
                $('#detalle_docente').html(array[0]);
                $('#agrega_tabla').html(array[1]);
                $('#x_clave').val(array[2]);
                $('#x_carga').val(array[3]);
                return false;
            }
        });
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-Modal de asignacion de materia horario--------------------------------- */
function  Modal_carga_materia(elemento){
    $('#form_carga_materia')[0].reset();
    $('#pro').val('Registro');
    $('#registra').show();
    $('#editar').hide();
    $('#eliminar').hide();
    $('#salon_idsalon').selectpicker('val', '');
    $('#grupo_idgrupo').selectpicker('val', '');
    $('#materia_idmateria').find('option').remove().end().append('<option value="">Selecciona</option>');
    $('#salon_idsalon').selectpicker();
    $('#grupo_idgrupo').selectpicker();
    //$('#materia_idmateria').selectpicker();
    $('#valor_materia').val('0');
    $('#modal_carga_materia_label').html("Agregar Nueva Clase");
    $('#modal_carga_materia').modal('show');

    $('#hora_oculta').val(elemento.parentNode.id);
    $('#hora').val(elemento.parentNode.id);
    $('#punto').val(elemento.id);
    var $dato = $('#x_clave').val();
    $('#clave').val($dato);
    var $dato_2 = $('#x_carga').val();
    $('#carga_idcarga').val($dato_2);
    return false;
};
/**------------------------------------------------------------------------ */
/**----Paginacion del salon para la carga de docentes---------------------- */
function Pagination_carga_docente_salon(partida){
    var url = $('#url_paginar_carga_salon').val();
    $.ajax({
        type:'POST',
        url:url,
        data:{partida:partida},
        success:function(data){
            var array = JSON.parse(data);
            $('#salon_select_salon').html(array[0]);
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**----Paginacion del grupo para la carga de docentes---------------------- */
function Pagination_carga_docente_grupo(partida){
    var url = $('#url_paginar_carga_grupo').val();
    $.ajax({
        type:'POST',
        url:url,
        data:{partida:partida},
        success:function(data){
            var array = JSON.parse(data);
            $('#grupo_select_grupo').html(array[0]);
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**----Paginacion de la materia para la carga de docente------------------- */
function Pagination_carga_docente_materia(){
    var url = $('#url_paginar_carga_materia').val();
    var idgrupo = $('#grupo_idgrupo').val();
    var idmateria = $('#valor_materia').val();
    $.ajax({
        type:'POST',
        url:url,
        data:{idgrupo:idgrupo, idmateria:idmateria},
        success:function(data){
            var jsvc = JSON.parse(data);
            $('#materia_idmateria').html(jsvc[0]);
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**Registro/Modificación de materias del docente en carga------------------ */
function Registrar_carga_materia(){
    $.ajax({
        type: 'POST',
        url: $('#form_carga_materia').attr('action'),
        data: $('#form_carga_materia').serialize(),
        success:function(data){
            var array = JSON.parse(data);
            var punto = array[0];
            var comprobar = array[2];
            if($('#pro').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_carga_materia').modal('toggle');
                    swal("Proceso terminado", "Registro Insertado Correctamente", "success");
                    $('#'+punto).html(array[1]);
                    return false;
                }else{

                }
            }else{
                if(comprobar == 0){
                    $('#modal_carga_materia').modal('toggle');
                    swal("Proceso terminado", "Registro Modificado Correctamente", "success");
                    $('#'+punto).html(array[1]);
                    return false;
                }else{

                }
            }
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**Modificación de Materias en la carga------------------------------------ */
function Modificar_carga_materia(id){
    var url = $('#url_modificar_carga_materia').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id='+id,
        success:function(valores){
            var datos = JSON.parse(valores);
            $('#form_carga_materia')[0].reset();
            $('#salon_idsalon').selectpicker('val', '');
            $('#grupo_idgrupo').selectpicker('val', '');
            $('#pro').val('Edicion');    
            $('#id').val(datos[0]);    
            $('#carga_idcarga').val(datos[1]);    
            $('#valor_materia').val(datos[2]);
            $('#salon_idsalon').selectpicker('val', datos[3]).change();
            $('#grupo_idgrupo').selectpicker('val', datos[4]).change(); 
            $('#clave').val(datos[5]);
            $('#hora').val(datos[6]);   
            $('#hora_oculta').val(datos[6]);
            $('#punto').val(datos[7]);               
            $('#registra').hide();    
            $('#editar').show();    
            $('#eliminar').show();    
            $('#modal_carga_materia').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**Eliminacion de materia en la carga del docente-------------------------- */
function Eliminar_carga_materia(ideliminar){
    var url = $('#url_eliminar_carga_materia').val();
    var iddetalle = $('#id').val();
    var idcarga = $('#carga_idcarga').val();
   
    swal({
        title: "Eliminar Registro?",
        text: "El registro se eliminara de forma permanente!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Confirmar!",
        closeOnConfirm: false,
        closeOnCancel: false
    },

    function(isConfirm){
        if (isConfirm) {

           $.ajax({
                type:'POST',
                url:url,
                data: {ideliminar: ideliminar, iddetalle: iddetalle, idcarga: idcarga},
                success:function(data){
                    var array = JSON.parse(data);
                    var iddocente = array[0];
                    $('#modal_carga_materia').modal('toggle');
                    swal("Proceso Terminado!", "Registro Eliminado Correctamente.", "success");
                    //$('#agrega-tabla').html(array[0]);
                    Examina_carga_individual(iddocente);
                    
                    return false;
                }
            });    
            
        }else{
            swal("Proceso Cancelado", "No se ha efectuado ningún cambio.", "error");
        }
    }); 
    return false;
};
/**------------------------------------------------------------------------ */