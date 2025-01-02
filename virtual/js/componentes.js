/*Funcion que va a manipular el sidebar ------------------------*/
function toggleMenu(){
    document.addEventListener("DOMContentLoaded", function() {
        const toggleButton = document.getElementById("toggleAsideButton");
        const sidenavMain = document.getElementById("sidenav-main");
        const btnMenuResponsive = document.getElementById("_toggle");
        // Lógica para pantallas pequeñas
        if (btnMenuResponsive && sidenavMain) {
            // En pantallas pequeñas, asignamos el evento de clic para alternar el menú
            btnMenuResponsive.addEventListener("click", function() {
                sidenavMain.classList.toggle("show");
                btnMenuResponsive.classList.toggle("close");
            });
        }

        // Lógica para pantallas grandes (ancho >= 992px)
        if (toggleButton && sidenavMain) {
            // En pantallas grandes no es necesario alternar el menú con el botón
            toggleButton.addEventListener("click", function() {
                sidenavMain.classList.toggle("collapsed");
                console.log("Boton cliqueado");
            });
        }
    });
};
toggleMenu();
/**------------------------------------------------------------ */

/**Funcion para mostrar u ocultar la contraseña de inicio de sesion */
function togglePasswordInicio(){
    const passwordField = document.getElementById('contrasena');
    const toggleIcon = document.getElementById('togglePassword');

    //Alternar el tipo de input entre password y text
    if(passwordField.type === 'password'){
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    }else{
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
};
/***--------------------------------------------------------------- */
/**Funcion para solo aceptar solo numeros en el input---------- */
function Solo_numeros(){
    $(".solonumeros").keydown(function(event){
        //alert(event.keyCode);
        if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode !==190  && event.keyCode !==110 && event.keyCode !==8 && event.keyCode !==9  ){
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------- */
/*Funcion para abrir el modal de inicio de sesión */
/*function Modal_iniciar_sesion(){
    $('#formulario_sesion')[0].reset();
    $('#error_sesion').hide();
    $('#validar_sesion').hide();
    $('#info_sesion').show();
    $('#modallogin').modal('show');
    return false;
};*/
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
            $('#hora_entrada_admon').val(datos[17]);
            $('#hora_salida_admon').val(datos[18]);
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
/**----------Pagination inputs horario de admon---------------------------- */
function Pagination_inputs_empleados(){
    var tp = $('#nivel_usuario').val();

    //Restaurar todos los campos de entrada primero (por si acaso)
    $('#hora_entrada_admon, #hora_salida_admon').prop('disabled', false);
    $('.columna_horario_admon').hide();

    //Verificar la seleccion y mostrar/habilitar campos de entrada según corresponda
    if(tp.indexOf('1') !== -1 || tp.indexOf('2') !== -1 || tp.indexOf('3') !== -1 || tp.indexOf('4') !== -1 || tp.indexOf('5') !== -1 || tp.indexOf('6') !== -1){
        $('#hora_entrada_admon').prop('disabled', false);
        $('#hora_entrada_a').show();
        $('#hora_salida_admon').prop('disabled', false);
        $('#hora_salida_a').show();    
    }
    return false;
};
/**------------------------------------------------------------------------ */
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
            $('#button_reporte_ssa').html(array[3]);
            $('#button_reporte_ssa_ex').html(array[4]);
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
                }else if(comprobar == 3){
                    swal({
                        title: 'Incorrecto',
                        text: 'El maximo del archivo es de 2 Megas',
                        type: 'error',
                        showConfirmButton: true
                    })
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
                }else if(comprobar == 3){
                    swal({
                        title: 'Incorrecto',
                        text: 'El maximo del archivo es de 2 Megas',
                        type: 'error',
                        showConfirmButton: true
                    })
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
                    Pagination_documentos(1);
                    return false;
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
/***Descargar documentos--------------------------------------------------- */
function Descargar_documento(id) {
    var url = $('#url_descargar_documento').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: { id: id },
        success: function (data) {
            if (data !== '') {
                // Construir la URL de descarga directa
                var url = '/itsa/virtual/documentos/' + data;
                //window.location.href = url;
                window.open(url, '_blank');
            } else {
                console.log("No se pudo obtener el nombre del archivo.");
            }
        },
        error: function(error){
            // Manejar el error aquí
            console.error("Error en la solicitud Ajax:", error);
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
/**Paginacion del modulo de asistencia ------------------------------------ */
function Pagination_asistencia(partida){
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
/**Modal de asistencia----------------------------------------------------- */
function Modal_configuracion_asistencia(){
    $('#form_asistencia')[0].reset();
    $('#btn_actualizar_documento_asistencia').hide();
    $('#btn_registrar_documento_asistencia').show();
    $('#proceso_asistencia').val('Registro');
    $('#alert_error_asistencia').hide();
    $('#modal_asistencia_label').html("Agregar Nuevo Documento de Asistencia");
    $('#modal_asistencia').modal('show');
    return false;
};
/**------------------------------------------------------------------------ */
/***Registrar documento de asistencia-------------------------------------- */
function Registrar_documento_asistencia(){
    var formData = new FormData($("#form_asistencia")[0]);
    $.ajax({
        type: 'POST',
        url: $('#form_asistencia').attr('action'),
        data: formData,
        processData: false,
        contentType: false,
        success:function(data){
            var array = JSON.parse(data);
            var comprobar = array[3];
            if($('#proceso_asistencia').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_asistencia').modal('toggle');
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
                }else if(comprobar == 2){
                    swal({
                        title: 'Incorrecto',
                        text: 'Por favor, eliga un Archivo .TXT',
                        type: 'error',
                        showConfirmButton: true
                    })
                    return false;
                }else{
                    $('#alert_error_asistencia').show();
                }
            }else{
                if(comprobar == 0){
                    $('#modal_asistencia').modal('toggle');
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
                }else if(comprobar == 2){
                    swal({
                        title: 'Incorrecto',
                        text: 'Por favor, eliga un Archivo .TXT',
                        type: 'error',
                        showConfirmButton: true
                    })
                    return false;
                }else{
                    $('#alert_error_asistencia').show();
                }
            }
        }
    });
    return false;
};
/*------------------------------------------------------------------------- */
/**Actualizacion del formato de asistencia--------------------------------- */
function Actualizar_asistencia(id){
    $('#form_asistencia')[0].reset();
    var url = $('#url_modificar').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id='+id,
        success:function(data){
            var cachetonypolar = JSON.parse(data);
            $('#proceso_asistencia').val('Edicion');
            $('#id_asistencia').val(cachetonypolar[0]);
            $('#fecha_inicio').val(cachetonypolar[1]);
            $('#fecha_fin').val(cachetonypolar[2]);
            $('#alert_error_asistencia').hide();
            $('#btn_registrar_documento_asistencia').hide();
            $('#btn_actualizar_documento_asistencia').show();
            $('#modal_asistencia_label').html("Actulizar Asistencia");
            $('#modal_asistencia').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**Eliminacion del formato de asistencia----------------------------------- */
function Eliminar_asistencia(ideliminar){
    var url = $('#url_paginar').val();
    var dato = '';
    var partida = '1';

    swal({
        title: "Eliminar Asistencia?",
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
/**Examinar la asistencia por quincena de todos los empleados-------------- */
function Examina_asistencia_quincenal(idasistencia){
    $('#contenido_pagina').load("modulos/detalle_asistencia.php", function Detalle_asistencia_procesado(){
        var url = "php/asistencia/consulta_detalle_asistencia.php";
        $.ajax({
            type: 'POST',
            url: url,
            data:{idasistencia: idasistencia},
            success:function(data){
                var array = JSON.parse(data);
                $('#detalle_quincena').html(array[0]);
                $('#agrega_tabla').html(array[1]);
                $('#x_identificador').val(array[2]);
                return false;
            }
        });
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**Paginacion del modulo de incidencia ------------------------------------ */
function Pagination_incidencia(partida){
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
/**Modal de asistencia----------------------------------------------------- */
function Modal_configuracion_incidencia(){
    $('#form_incidencia')[0].reset();
    $('#exp_emp_incidencia').selectpicker('val', '');
    $('#btn_registrar_incidencia').show();
    $('#btn_actualizar_incidencia').hide();
    $('#proceso_incidencia').val('Registro');
    $('#alert_error_incidencia').hide();
    Pagination_info_incidencia(1);
    $('#modal_incidencia_label').html("Agregar Nueva Incidencia");
    $('#modal_incidencia').modal('show');
    return false;
};
/**------------------------------------------------------------------------ */
/***Registrar documento de asistencia-------------------------------------- */
function Registrar_incidencia(){
    $.ajax({
        type:'POST',
        url:$('#form_incidencia').attr('action'),
        data:$('#form_incidencia').serialize(),
        success:function(data){
            var array = JSON.parse(data);
            var comprobar = array[3];
            if($('#proceso_incidencia').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_incidencia').modal('toggle');
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
                    $('#alert_error_incidencia').show();
                }
            }else{
                if(comprobar == 0){
                    $('#modal_incidencia').modal('toggle');
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
                    $('#alert_error_incidencia').show();
                }
            }
        }
    });
    return false;
};
/*------------------------------------------------------------------------- */
/**---------------------Buscar select empleados---------------------------- */
function Pagination_select_empleados(partida){
    var url = $('#url_buscar_empleados').val();
    //$('#exp_emp').selectpicker('val', '');
    $.ajax({
        type:'POST',
        url:url,
        data:{partida:partida},
        success:function(data){
            var array = JSON.parse(data);
            //$('#exp_emp').empty().append(array[0]);
            //$('.selectpicker').selectpicker('refresh');
            $('#incidencia_empleado_incidencia').html(array[0]);
            //$('#exp_emp').html(array[0]);
            //$('#exp_emp').selectpicker('refresh');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**----Buscar select de  claves movimientos RH----------------------------- */
function Pagination_select_claves_movimiento(partida){
    var url = $('#url_buscar_claves_movimiento').val();
    $.ajax({
        type: 'POST',
        url:url,
        data:{partida:partida},
        success:function(data){
            var valcor = JSON.parse(data);
            $('#id_clave_mov').html(valcor[0]);
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**---Buscar info de folio y hora------------------------------------------ */
function Pagination_info_incidencia(partida){
    var url = $('#url_buscar_info').val();
    $.ajax({
        type: 'POST',
        url:url,
        data:{partida:partida},
        success:function(data){
            var valle = JSON.parse(data);
            $('#incidencia_hora').val(valle[0]);
            $('#incidencia_folio').val(valle[1]);
            $('#fElaboracion').val(valle[2]);
            //console.log(valle[0]);
            //console.log(valle[1]);            
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/****Actualizar incidencia------------------------------------------------- */
function Actualizar_incidencia(id){
    $('#form_incidencia')[0].reset();
    $('#exp_emp_incidencia').selectpicker('val', '');
    var url = $('#url_modificar').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id='+id,
        success:function(data){
            var cachetonypolar = JSON.parse(data);
            $('#proceso_incidencia').val('Edicion');
            $('#exp_emp_incidencia').selectpicker('val', '');
            $('#id_incidencia').val(cachetonypolar[0]);
            $('#incidencia_folio').val(cachetonypolar[1]);
            $('#exp_emp_incidencia').selectpicker('val', cachetonypolar[2]).change();
            $('#fInicio').val(cachetonypolar[3]);
            $('#fFin').val(cachetonypolar[4]);
            $('#fElaboracion').val(cachetonypolar[5]);
            $('#id_clave_mov').val(cachetonypolar[6]).change();
            $('#observacion').val(cachetonypolar[7]);
            $('#incidencia_hora').val(cachetonypolar[8]);
            $('#alert_error_incidencia').hide();
            $('#btn_registrar_incidencia').hide();
            $('#btn_actualizar_incidencia').show();
            $('#modal_incidencia_label').html("Actulizar Incidencia");
            $('#modal_incidencia').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-----Eliminar incidencia------------------------------------------------ */
function Eliminar_incidencia(ideliminar){
    var url = $('#url_paginar').val();
    var dato = '';
    var partida = '1';

    swal({
        title: "Eliminar Incidencia?",
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
/**-----Paginacion del dia inhabil ---------------------------------------- */
function Pagination_dia_inhabil(partida){
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
/**------Modal de dia inhabil---------------------------------------------- */
function Modal_configuracion_dia_inhabil(){
    $('#form_dia_inhabil')[0].reset();
    $('#btn_registrar_dia_i').show();
    $('#btn_actualizar_dia_i').hide();
    $('#proceso_dia_inhabil').val('Registro');
    $('#alert_error_dia_inhabil').hide();
    $('#modal_dia_inhabil_label').html("Agregar Nuevo Día Inhábil");
    $('#modal_dia_inhabil').modal('show');
    return false;
    
};
/**------------------------------------------------------------------------ */
/**----Registrar el dia inhabil-------------------------------------------- */
function Registrar_dia_inhabil(){
    $.ajax({
        type:'POST',
        url:$('#form_dia_inhabil').attr('action'),
        data:$('#form_dia_inhabil').serialize(),
        success:function(data){
            var array = JSON.parse(data);
            var comprobar = array[3];
            if($('#proceso_dia_inhabil').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_dia_inhabil').modal('toggle');
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
                    $('#alert_error_dia_inhabil').show();
                }
            }else{
                if(comprobar == 0){
                    $('#modal_dia_inhabil').modal('toggle');
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
                    $('#alert_error_dia_inhabil').show();
                }
            }
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/*****Actualizar dia inhabil----------------------------------------------- */
function Actualizar_dia_inhabil(id){
    $('#form_dia_inhabil')[0].reset();
    var url = $('#url_modificar').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id='+id,
        success:function(data){
            var cachetonypolar = JSON.parse(data);
            $('#proceso_dia_inhabil').val('Edicion');
            $('#id_dia_inhabil').val(cachetonypolar[0]);
            $('#fDia_i').val(cachetonypolar[1]);
            $('#concepto_dia_i').val(cachetonypolar[2]);
            $('#alert_error_dia_inhabil').hide();
            $('#btn_registrar_dia_i').hide();
            $('#btn_actualizar_dia_i').show();
            $('#modal_dia_inhabil_label').html("Actulizar Día Inhábil");
            $('#modal_dia_inhabil').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**Eliminar Dia Inhabil---------------------------------------------------- */
function Eliminar_dia_inhabil(ideliminar){
    var url = $('#url_paginar').val();
    var dato = '';
    var partida = '1';

    swal({
        title: "Eliminar Día Inhábil?",
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
/***-----Paginacion de los vehiculos--------------------------------------- */
function Pagination_vehiculo(partida){
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
/**funcion para abrir el modal del parque vehicular------------------------ */
function Modal_configuracion_vehiculo(){
    $('#form_vehiculo')[0].reset();
    $('#btn_agregar_vehiculo').show();
    $('#btn_actualizar_vehiculo').hide();
    $('#proceso_vehiculo').val('Registro');
    $('#alert_error').hide();
    $('#modal_vehiculo_label').html("Agregar Nuevo Vehiculo");
    $('#modal_vehiculo').modal('show');
    return false;
};
/**------------------------------------------------------------------------ */
/**funcion para registrar un vehiculo-------------------------------------- */
function Registrar_vehiculo(){
    $.ajax({
        type:'POST',
        url:$('#form_vehiculo').attr('action'),
        data:$('#form_vehiculo').serialize(),
        success:function(data){
            var array = JSON.parse(data);
            var comprobar = array[3];
            if($('#proceso_vehiculo').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_vehiculo').modal('toggle');
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
                    $('#modal_vehiculo').modal('toggle');
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
/**funcion para actualizar los datos de un vehiculo------------------------ */
function Actualizar_vehiculo(id){
    $('#form_vehiculo')[0].reset();
    var url = $('#url_modificar').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id='+id,
        success:function(data){
            var cachetonypolar = JSON.parse(data);
            $('#proceso_vehiculo').val('Edicion');
            $('#id_vehiculo').val(cachetonypolar[0]);
            $('#placa').val(cachetonypolar[1]);
            $('#noserie').val(cachetonypolar[2]);
            $('#kminicial').val(cachetonypolar[3]);
            $('#tipo').val(cachetonypolar[4]);
            $('#cilindro').val(cachetonypolar[5]);
            $('#kmporlitro').val(cachetonypolar[6]);
            $('#modelo').val(cachetonypolar[7]);
            $('#color').val(cachetonypolar[8]);
            $('#marca').val(cachetonypolar[9]);
            $('#submarca').val(cachetonypolar[10]);
            $('#alert_error').hide();
            $('#btn_agregar_vehiculo').hide();
            $('#btn_actualizar_vehiculo').show();
            $('#modal_vehiculo_label').html("Actulizar Vehiculo");
            $('#modal_vehiculo').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**funcion para eliminar el registro de un vehiculo------------------------ */
function Eliminar_vehiculo(ideliminar){
    var url = $('#url_paginar').val();
    var dato = '';
    var partida = '1';

    swal({
        title: "Eliminar Vehiculo?",
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
/**funcion para paginacion de un combustible------------------------------- */
function Pagination_combustible(partida){
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
/**funcion para modal de combustible--------------------------------------- */
function Modal_configuracion_combustible(){
    $('#form_combustible')[0].reset();
    $('#btn_agregar_combustible').show();
    $('#btn_actualizar_combustible').hide();
    $('#proceso_combustible').val('Registro');
    $('#alert_error').hide();
    $('#modal_combustible_label').html("Agregar Nuevo Combustible");
    $('#modal_combustible').modal('show');
    return false;
};
/**------------------------------------------------------------------------ */
/**funcion para registrar un combustible----------------------------------- */
function Registrar_combustible(){
    $.ajax({
        type:'POST',
        url:$('#form_combustible').attr('action'),
        data:$('#form_combustible').serialize(),
        success:function(data){
            var array = JSON.parse(data);
            var comprobar = array[3];
            if($('#proceso_combustible').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_combustible').modal('toggle');
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
                    $('#modal_combustible').modal('toggle');
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
/**funcion para actualizar los datos del combustible------------------------ */
function Actualizar_combustible(id){
    $('#form_combustible')[0].reset();
    var url = $('#url_modificar').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id='+id,
        success:function(data){
            var peito = JSON.parse(data);
            $('#proceso_combustible').val('Edicion');
            $('#id_combustible').val(peito[0]);
            $('#nombre_combustible').val(peito[1]);
            $('#precio_combustible').val(peito[2]);
            $('#alert_error').hide();
            $('#btn_agregar_combustible').hide();
            $('#btn_actualizar_combustible').show();
            $('#modal_combustible_label').html("Actulizar Combustible");
            $('#modal_combustible').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**funcion para eliminar el registro de un vehiculo------------------------ */
function Eliminar_combustible(ideliminar){
    var url = $('#url_paginar').val();
    var dato = '';
    var partida = '1';

    swal({
        title: "Eliminar Combustible?",
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
/**----------Funcion para la paginacion de licencia------------------------ */
function Pagination_licencia(partida){
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
/**----------Funcion select empleados para licencias*---------------------- */
function Pagination_empleados_licencia(partida){
    var url = $('#url_buscar_empleados').val();
    $.ajax({
        type:'POST',
        url:url,
        data:{partida:partida},
        success:function(data){
            var array = JSON.parse(data);
            $('#licencia_empleado_licencia').html(array[0]);
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**---------Modal de licencia--------------------------------------------- */
function Modal_configuracion_licencia(){
    $('#form_licencia')[0].reset();
    $('#exp_emp_licencia').selectpicker('val', '');
    $('#btn_registrar_licencia').show();
    $('#btn_actualizar_licencia').hide();
    $('#proceso_licencia').val('Registro');
    $('#alert_error').hide();
    Pagination_info_licencia(1);
    $('#modal_licencia_label').html("Agregar Nueva Licencia");
    $('#modal_licencia').modal('show');
    return false;
};
/**------------------------------------------------------------------------ */
/**---------Info de la licencia-------------------------------------------- */
function Pagination_info_licencia(partida){
    var url = $('#url_buscar_info').val();
    $.ajax({
        type: 'POST',
        url:url,
        data:{partida:partida},
        success:function(data){
            var valle = JSON.parse(data);
            $('#hora_l').val(valle[0]);
            $('#folio_l').val(valle[1]);
            $('#fecha_ela_l').val(valle[2]);       
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**Funcion para Registrar licencia----------------------------------------- */
function Registrar_licencia(){
    $.ajax({
        type:'POST',
        url:$('#form_licencia').attr('action'),
        data:$('#form_licencia').serialize(),
        success:function(data){
            var array = JSON.parse(data);
            var comprobar = array[3];
            if($('#proceso_licencia').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_licencia').modal('toggle');
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
                    $('#modal_licencia').modal('toggle');
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
/****Modificar la licencia------------------------------------------------- */
function Actualizar_licencia(id){
    $('#form_licencia')[0].reset();
    var url = $('#url_modificar').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id='+id,
        success:function(data){
            var peito = JSON.parse(data);
            $('#proceso_licencia').val('Edicion');
            $('#id_licencia').val(peito[0]);
            $('#folio_l').val(peito[1]);
            $('#exp_emp_licencia').selectpicker('val', peito[2]).change();
            $('#concepto').val(peito[3]);
            $('#fecha_ela_l').val(peito[4]);
            $('#hora_l').val(peito[5]);
            $('#fInicio').val(peito[6]);
            $('#fFin').val(peito[7]);
            $('#alert_error').hide();
            $('#btn_registrar_licencia').hide();
            $('#btn_actualizar_licencia').show();
            $('#modal_licencia_label').html("Actulizar Licencia");
            $('#modal_licencia').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-Eliminar la licencia--------------------------------------------------- */
function Eliminar_licencia(ideliminar){
    var url = $('#url_paginar').val();
    var dato = '';
    var partida = '1';

    swal({
        title: "Eliminar Licencia?",
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
/**----------Funcion para la paginacion de choferes------------------------ */
function Pagination_chofer(partida){
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
/**----------Funcion select empleados para choferes*---------------------- */
function Pagination_empleados_chofer(partida){
    var url = $('#url_buscar_empleados').val();
    $.ajax({
        type:'POST',
        url:url,
        data:{partida:partida},
        success:function(data){
            var array = JSON.parse(data);
            $('#chofer_empleado_chofer').html(array[0]);
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**---------Modal de licencia--------------------------------------------- */
function Modal_configuracion_chofer(){
    $('#form_chofer')[0].reset();
    $('#exp_emp_chofer').selectpicker('val', '');
    $('#btn_agregar_chofer').show();
    $('#btn_actualizar_chofer').hide();
    $('#proceso_chofer').val('Registro');
    $('#alert_error').hide();
    $('#modal_chofer_label').html("Agregar Nuevo Chofer");
    $('#modal_chofer').modal('show');
    return false;
};
/**------------------------------------------------------------------------ */
/***----Funcion para registro de choferes---------------------------------- */
function Registrar_chofer(){
    $.ajax({
        type:'POST',
        url:$('#form_chofer').attr('action'),
        data:$('#form_chofer').serialize(),
        success:function(data){
            var array = JSON.parse(data);
            var comprobar = array[3];
            if($('#proceso_chofer').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_chofer').modal('toggle');
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
                    $('#modal_chofer').modal('toggle');
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
/***----Funcion para modificar--------------------------------------------- */
function Actualizar_chofer(id){
    $('#form_chofer')[0].reset();
    var url = $('#url_modificar').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id='+id,
        success:function(data){
            var peito = JSON.parse(data);
            $('#proceso_chofer').val('Edicion');
            $('#id_chofer').val(peito[0]);
            $('#exp_emp_chofer').selectpicker('val', peito[1]).change();
            $('#alert_error').hide();
            $('#btn_agregar_chofer').hide();
            $('#btn_actualizar_chofer').show();
            $('#modal_chofer_label').html("Actulizar Chofer");
            $('#modal_chofer').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-----Funcion para eliminar---------------------------------------------- */
function Eliminar_chofer(ideliminar){
    var url = $('#url_paginar').val();
    var dato = '';
    var partida = '1';

    swal({
        title: "Eliminar Chofer?",
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
/**------Paginacion empleados para comision-------------------------------- */
function Pagination_empleados_comision(partida){
    var url = $('#url_buscar_empleados').val();
    $.ajax({
        type:'POST',
        url:url,
        data:{partida:partida},
        success:function(data){
            var array = JSON.parse(data);
            $('#comision_empleado_comision').html(array[0]);
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**------Modal para comision del departamento de personal------------------ */
function Modal_configuracion_comision_dp(){
    $('#form_comision_dp')[0].reset();
    $('#exp_emp_comision').selectpicker('val', '');
    $('#btn_agregar_comision_dp').show();
    $('#btn_actualizar_comision_dp').hide();
    $('#proceso_comision_dp').val('Registro');
    $('#alert_error').hide();
    $('#alert_error_2').hide();
    $('#alert_error_3').hide();
    Pagination_informacion_comision();
    $('#modal_comision_dp_label').html("Asignar Nuevo Comisionado");
    $('#modal_comision_dp').modal('show');
    return false;
};
/**------------------------------------------------------------------------ */
/**Funcion para informacion de la comision folio y fecha------------------- */
function Pagination_informacion_comision(){
    var url = $('#url_info_comision').val();
    var partida = 1;
    $.ajax({
        type:'POST',
        url:url,
        data:{partida:partida},
        success:function(data){
            var logan = JSON.parse(data);
            $('#fecha_comision').val(logan[0]);
            $('#folio_comision').val(logan[1]);
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**Funcion para informacion del empleado al seleecionar-------------------- */
function Pagination_info_comision() {
    var url = $('#url_info_empleado_comision').val();
    var empleados = $('#exp_emp_comision').val(); // Esto ahora es un array

    // Limpiar los valores anteriores
    $('#lugar').val('');
    $('#n_comi').val('');
    $('#cargo').val('');
    $('#id_plaza').val('');

    $.ajax({
        type: 'POST',
        url: url,
        data: {empleado: empleados},
        success: function(data) {
            try {
                var valcor = JSON.parse(data);

                // Mostrar los datos generales
                $('#lugar').val(valcor[0]['lugar']);
                $('#n_comi').val(valcor[0]['n_comi']);

                // Mostrar los datos específicos de cada empleado
                var cargos = [];
                var id_plazas = [];
                for (var i = 1; i < valcor.length; i++) {
                    cargos.push(valcor[i]['cargo']);
                    id_plazas.push(valcor[i]['id_cargo']);
                }
                $('#cargo').val(cargos.join(', '));
                $('#id_plaza').val(id_plazas.join(', '));

            } catch (e) {
                console.error('Error parsing JSON:', e, data);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error in AJAX request:', textStatus, errorThrown);
        }
    });

    return false;
}
/*function Pagination_info_comision(){
    var url = $('#url_info_empleado_comision').val();
    var empleado = $('#exp_emp_comision').val();
    
    $.ajax({
        type:'POST',
        url:url,
        data:{empleado:empleado},
        success:function(data){
            var valcor = JSON.parse(data);
            $('#lugar').val(valcor[0]);
            $('#n_comi').val(valcor[1]);
            $('#cargo').val(valcor[2]);
            $('#id_plaza').val(valcor[3]);
            return false;
        }
    });
    return false;
};*/
/**------------------------------------------------------------------------ */
/**Funcion para obtener la duracion de la comision------------------------- */
function Pagination_validar_comision() {
    // Obtén los valores de los inputs
    var finicio = $('#fInicio').val().trim();
    var ffin = $('#fFin').val().trim();
    var hini = $('#hora_incio').val().trim();
    var hfin = $('#hora_fin').val().trim();

    // Verifica si todos los inputs tienen valor
    if (finicio !== '' && ffin !== '' && hini !== '' && hfin !== '') {
        var url = $('#url_validacion_comision').val();
        var empleado = $('#exp_emp_comision').val();
        $.ajax({
            type: 'POST',
            url: url,
            data: { finicio:finicio, ffin:ffin, hini:hini, hfin:hfin, empleado:empleado },
            success: function (data) {
                var valcor = JSON.parse(data);
                $('#duracion').val(valcor[0]);
                return false;
            }
        });
    } else {
        console.log('Aún no todos los inputs tienen valor.');
    }

    return false;
};
/**------------------------------------------------------------------------ */
/***-----Registrar el formulario correspondiente a personal de la comision- */
function Registrar_comision_dp(){
    $.ajax({
        type:'POST',
        url:$('#form_comision_dp').attr('action'),
        data:$('#form_comision_dp').serialize(),
        success:function(data){
            var array = JSON.parse(data);
            var comprobar = array[0];//Modificar cuando compongamos la paginacion
            if($('#proceso_comision_dp').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_comision_dp').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Agregado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    /*$('#agrega-registros').html(array[0]);
                    $('#pagination_info').html(array[1]);
                    $('#pagination').html(array[2]);
                    $('[data-bs-toggle="tooltip"]').tooltip();*/// Inicializa todos los tooltips
                    return false;
                }else if(comprobar == 1){
                    $('#alert_error').show();
                }else if(comprobar == 2){
                    $('#alert_error_3').show();
                }else if(comprobar == 3){
                    $('#alert_error_2').show();
                }
            }else{
                if(comprobar == 0){
                    $('#modal_comision_dp').modal('toggle');
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
                }else if(comprobar == 2){
                    $('#alert_error_comision').show();
                }else if(comprobar == 1){
                    $('#alert_error_comision_2').show();
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
            // Manejar errores según sea necesario
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**funcion para paginacion de una comision--------------------------------- */
function Pagination_comision(partida){
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
/**Actualizar comision ---------------------------------------------------- */
function Actualizar_comision_dp(id){
    $('#form_comision_dp')[0].reset();
    var url = $('#url_modificar_dp').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id='+id,
        success:function(data){
            var peito = JSON.parse(data);
            $('#proceso_comision_dp').val('Edicion');
            $('#id_comision_dp').val(peito[0]);
            $('#id_plaza').val(peito[1]);
            $('#exp_emp_comision').selectpicker('val', peito[2]).change();
            $('#lugar').val(peito[3]);
            $('#fecha_comision').val(peito[4]);
            $('#n_comi').val(peito[5]);
            $('#folio_comision').val(peito[6]);
            $('#cargo').val(peito[7]);
            $('#fInicio').val(peito[8]);
            $('#fFin').val(peito[9]);
            $('#hora_incio').val(peito[10]);
            $('#hora_fin').val(peito[11]);
            $('#finalidad').val(peito[12]);
            $('#duracion').val(peito[13]);
            $('#pais').val(peito[14]);
            $('#estado').val(peito[15]);
            $('#municipio').val(peito[16]);
            $('#lugar_comision').val(peito[17]);
            $('#alert_error').hide();
            $('#alert_error_2').hide();
            $('#btn_agregar_comision_dp').hide();
            $('#btn_actualizar_comision_dp').show();
            $('#modal_comision_dp_label').html("Actulizar Comisión");
            $('#modal_comision_dp').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**Eliminar Comision------------------------------------------------------- */
function Eliminar_comision_dp(ideliminar){
    var url = $('#url_paginar').val();
    var dato = '';
    var partida = '1';

    swal({
        title: "Eliminar Comisión?",
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
/**Funcion para asignar viaticos al comisionado---------------------------- */
function Viaticos_comision(id_viaticos, id_comision){
    if(id_viaticos > 0){
        Modificar_viaticos(id_viaticos);
    }else{
        $('#form_comision_rf')[0].reset();
        $('#id_comision_rf').val(id_viaticos);
        $('#comision_id_comision').val(id_comision);
        $('#proceso_comision_rf').val('Registro')
        $('#alert_error_rf').hide();
        $('#btn_agregar_comision_rf').show();
        $('#btn_actualizar_comision_rf').hide();
        // Restaurar todos los campos de entrada primero (por si acaso)
        $('#input_especificar_rf').hide();
        $('#especificar').val('').prop('disabled', true);
        $('#modal_comision_rf_label').html('Agregar Viaticos Comisión')
        $('#modal_comision_rf').modal('show');
    }  
    return false;
};
/**------------------------------------------------------------------------ */
/**---Registro de viativos ------------------------------------------------ */
function Registrar_comision_rf(){
    $.ajax({
        type:'POST',
        url:$('#form_comision_rf').attr('action'),
        data:$('#form_comision_rf').serialize(),
        success:function(data){
            var array = JSON.parse(data);
            var comprobar = array[0];
            if($('#proceso_comision_rf').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_comision_rf').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Agregado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    Pagination_comision(1);
                    return false;
                }else{
                    $('#alert_error_rf').show();
                }
            }else{
                if(comprobar == 0){
                    $('#modal_comision_rf').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Actualizado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    Pagination_comision(1);
                    return false;
                }else{
                    $('#alert_error_rf').show();
                }
            }
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/***Actualizar viaticos --------------------------------------------------- */
function Modificar_viaticos(id_viaticos){
    $('#form_comision_dp')[0].reset();
    var url = $('#url_modificar_viaticos').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id='+id_viaticos,
        success:function(data){
            var peito = JSON.parse(data);
            $('#proceso_comision_rf').val('Edicion')
            $('#id_comision_rf').val(peito[0]);
            $('#comision_id_comision').val(peito[1]);
            $('#viatico').val(peito[2]);
            $('#combustible').val(peito[3]);
            $('#casetas').val(peito[4]);
            $('#otros').val(peito[5]);
            var otros = peito[5];
            if (otros > 0) {
                $('#input_especificar_rf').show();
                $('#especificar').prop('disabled', false);
            } else {
                $('#input_especificar_rf').hide();
                $('#especificar').prop('disabled', true);
            }
            $('#especificar').val(peito[6]);
            $('#total').val(peito[7]);
            $('#alert_error_rf').hide();
            $('#btn_agregar_comision_rf').hide();
            $('#btn_actualizar_comision_rf').show();
            $('#modal_comision_rf_label').html("Actulizar Viaticos Comisión");
            $('#modal_comision_rf').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-----Suma de los viaticos----------------------------------------------- */
function Suma_viaticos() {
    // Obtén los valores de los inputs
    var viatico = parseFloat($('#viatico').val().trim()) || 0;
    var combustible = parseFloat($('#combustible').val().trim()) || 0;
    var casetas = parseFloat($('#casetas').val().trim()) || 0;
    var otros = parseFloat($('#otros').val().trim()) || 0;

    // Verifica si todos los inputs tienen valor
    if (isNaN(viatico) || viatico <= 0) {
        $('#viatico').val('00.00');
    }
    if (isNaN(combustible) || combustible <= 0) {
        $('#combustible').val('00.00');
    }
    if (isNaN(casetas) || casetas <= 0) {
        $('#casetas').val('00.00');
    }
    if (isNaN(otros) || otros <= 0) {
        $('#otros').val('00.00');
    }
    // Restaurar todos los campos de entrada primero (por si acaso)
    $('#input_especificar_rf').hide();
    $('#especificar').val('').prop('disabled', true);

    if (otros > 0) {
        $('#input_especificar_rf').show();
        $('#especificar').prop('disabled', false);
    } else {
        $('#input_especificar_rf').hide();
        $('#especificar').prop('disabled', true);
    }

    var url = $('#url_suma_total').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: { viatico: viatico, combustible: combustible, casetas: casetas, otros: otros },
        success: function (data) {
            var valcor = JSON.parse(data);
            $('#total').val(valcor[0]);
            return false;
        }
    });

    return false;
};
/**------------------------------------------------------------------------ */
/**Funcion para asignar un vehiculo al comisionado------------------------- */
function Parque_comision(id_parque, id_comision){
    Fechas_horas_pv(id_comision);
    if(id_parque > 0){
        Modificar_parque_comision(id_parque);
    }else{
        $('#form_comision_pv')[0].reset();
        $('#id_comision_pv').val(id_parque);
        $('#comision_id_comision_pv').val(id_comision);
        $('#proceso_comision_pv').val('Registro')
        $('#alert_error_pv').hide();
        $('#especificar, #vehiculo_comision, #placas, #km_inicial').prop('disabled', false);
        $('#input_especificar_pv, #select_id_vehiculo, #input_placas, #input_km_inicial').hide();
        $('#vehiculo_comision').selectpicker('val', '');
        $('#btn_agregar_comision_pv').show();
        $('#btn_actualizar_comision_pv').hide();
        $('#modal_comision_pv_label').html('Agregar Vehiculo Comisión')
        $('#modal_comision_pv').modal('show');
    }  
    return false;
};
/**------------------------------------------------------------------------ */
/**Fecha y hora para el parque vehicular----------------------------------- */
function Fechas_horas_pv(id){
    var url = $('#url_fecha_hora_pv').val();
    $.ajax({
        type: 'POST',
        url:url,
        data:{id:id},
        success:function(data){
            var logan = JSON.parse(data);
            $('#f_ini_pv').val(logan[0]);
            $('#f_fin_pv').val(logan[1]);
            $('#h_ini_pv').val(logan[2]);
            $('#h_fin_pv').val(logan[3]);
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**Funcion para registrar un automivil a la comision----------------------- */
function Registrar_comision_pv(){
    $.ajax({
        type:'POST',
        url:$('#form_comision_pv').attr('action'),
        data:$('#form_comision_pv').serialize(),
        success:function(data){
            var array = JSON.parse(data);
            var comprobar = array[0];
            if($('#proceso_comision_pv').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_comision_pv').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Agregado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    Pagination_comision(1);
                    return false;
                }else{
                    $('#alert_error_pv').show();
                }
            }else{
                if(comprobar == 0){
                    $('#modal_comision_pv').modal('toggle');
                    swal({
                        title: 'Proceso Terminado',
                        text: 'Registro Actualizado Correctamente',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    Pagination_comision(1);
                    return false;
                }else{
                    $('#alert_error_pv').show();
                }
            }
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**--Modificar Parque Comision--------------------------------------------- */
function Modificar_parque_comision(id_parque){
    $('#form_comision_pv')[0].reset();
    var url = $('#url_modificar_vehiculo').val();
    $.ajax({
        type: 'POST',
        url:url,
        data: 'id='+id_parque,
        success:function(data){
            var peito = JSON.parse(data);
            $('#proceso_comision_pv').val('Edicion');
            $('#id_comision_pv').val(peito[0]);
            $('#comision_id_comision_pv').val(peito[1]);
            $('#tipo_vehiculo').val(peito[2]).change();
            $('#especificar_vehiculo').val(peito[3]);
            $('#vehiculo_comision').selectpicker('val', peito[4]).change();
            //$('#placas').val(peito[5]); 
            $('#km_inicial').val(peito[5]);
            $('#alert_error_pv').hide();
            $('#btn_agregar_comision_pv').hide();
            $('#btn_actualizar_comision_pv').show();
            $('#modal_comision_pv_label').html("Actulizar Vehiculo Comisión");
            $('#modal_comision_pv').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**Paginacion para los input del parque vehicular de comision-------------- */
function Pagination_tipo_vehiculo(){
    var tipo = $('#tipo_vehiculo').val();
   //Restaurar todos los campos de entrada primero (por si acaso)
   $('#especificar, #vehiculo_comision, #placas, #km_inicial').prop('disabled', false);
   $('#input_especificar_pv, #select_id_vehiculo, #input_placas, #input_km_inicial').hide();
    
    
   //Verificar la seleccion y mostrar/habilitar campos de entrada según corresponda
   if(tipo.indexOf('1') !== -1 ){
       //$('#especificar').prop('disabled', false);
       //$('#input_especificar_pv').show();
       $('#vehiculo_comision').selectpicker('val', '');
        $('#placas').val("");
        $('#km_inicial').val("");  
        $('#especificar_vehiculo').val("");
   }else if(tipo.indexOf('2') !== -1 ){
        $('#vehiculo_comision, #placas, #km_inicial').prop('disabled', false);
        $('#select_id_vehiculo, #input_placas, #input_km_inicial').show();
        $('#vehiculo_comision').selectpicker('val', '');
        $('#placas').val("");
        $('#km_inicial').val("");  
        $('#especificar_vehiculo').val("");
    }else if(tipo.indexOf('3') !== -1){
        $('#especificar_vehiculo').prop('disabled', false);
        $('#input_especificar_pv').show();
        $('#vehiculo_comision').selectpicker('val', '');
        $('#placas').val("");
        $('#km_inicial').val("");  
        $('#especificar_vehiculo').val("");
    }
    return false;

};
/**------------------------------------------------------------------------ */
/**Funcion para obtener los vehiculos dados de alta en el PV--------------- */
function Pagination_vehiculo_comision(partida){
    var url = $('#url_buscar_vehiculo').val();
    /*$('#especificar').reset();
    $('#vehiculo_comision').selectpicker('val', '');
    $('#placas').reset();
    $('#km_inicial').reset();   */
    $.ajax({
        type:'POST',
        url:url,
        data:{partida:partida},
        success:function(data){
            var array = JSON.parse(data);
            $('#vehiculo_id_vehiculo').html(array[0]);
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**Funcion para manejar el llenado de placas y kilometraje----------------- */
function Datos_vehiculo(){
    var url = $('#url_datos_vehiculo').val();
    var carro = $('#vehiculo_comision').val();
    $.ajax({
        type: 'POST',
        url:url,
        data:{carro:carro},
        success:function(data){
            var mishos = JSON.parse(data);
            $('#placas').val(mishos[0]);
            $('#km_inicial').val(mishos[1]);
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**Paginacion del compacto de comisiones----------------------------------- */
function Pagination_compacto_comision(partida){
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
/**Modal para agregar una nueva compactasion------------------------------- */
function Modal_configuracion_compacto_comision(){
    $('#form_compacto_comision')[0].reset();
    $('#id_comisiones').selectpicker('val', '');
    $('#id_departamentos').selectpicker('val', '');
    $('#proceso').val('Registro');
    $('#alert_error').hide();
    $('#alert_error_2').hide();
    $('#btn_registrar').show();
    $('#input_km_2').hide();
    $('.inputs_vehiculo_comision').show();
    $('#btn_actualizar').hide();
    $('#modal_compacto_comision_label').html("Registrar Compacto de Comisiones");
    $('#modal_compacto_comision').modal('show');
    return false;
};
/**------------------------------------------------------------------------ */
/**Funcion Registro /Edicion del compacto de comision---------------------- */
function Registrar_compacto_comision(){
    $.ajax({
        type:'POST',
        url:$('#form_compacto_comision').attr('action'),
        data:$('#form_compacto_comision').serialize(),
        success:function(data){
            var array = JSON.parse(data);
            var comprobar = array[3];
            if($('#proceso').val() == 'Registro'){
                if(comprobar == 0){
                    $('#modal_compacto_comision').modal('toggle');
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
                    $('#modal_compacto_comision').modal('toggle');
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
/**Select para mostar todas la comisiones y seleccionar-------------------- */
function Pagination_comisiones_select(partida){
    var url = $('#url_buscar_comisiones').val();
    $.ajax({
        type: 'POST',
        url: url,
        data:{partida:partida},
        success:function(data){
            //var josan = JSON.parse(data);
            $('#comision_id_comision').html(data);
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**---------Buscar las gasolinas para comision----------------------------- */
function Buscar_gasolina_comision(partida){
    var url = $('#url_gasolina_comision').val();
    $.ajax({
        type: 'POST',
        url: url, 
        data:{partida:partida},
        success:function(data){
            var corona = JSON.parse(data);
            $('#tipo_gasolina').html(corona[0]);
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**------Buscar los departamentos para la comision------------------------- */
function Pagination_departamentos_comision_select(partida){
    var url = $('#url_departamentos_comision').val();
    $.ajax({
        type: 'POST',
        url: url, 
        data:{partida:partida},
        success:function(valcor){
            //var valle = JSON.parse(data);
            $('#departamento_id_departamento').html(valcor);
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**----Funcion para validar los vehiculos de las comisiones seleccionadas-- */
function Validar_comisiones_vehiculo(){
    var url = $('#url_validar_comision').val();
    var comisiones = $('#id_comisiones').val();
    $.ajax({
        type: 'POST',
        url: url,
        data:{comisiones:comisiones},
        success:function(datos){
            var cacheton = JSON.parse(datos);
            var comprobar = cacheton[0];
            if (comprobar == 0){
                $('#nombre_vehiculo').val(cacheton[1]);
                $('#km_inicial').val(cacheton[2]);
                $('#id_vehiculo').val(cacheton[3]);
                $('#alert_error_2').hide();
                $('.inputs_vehiculo_comision').show();
            }else{
                $('#nombre_vehiculo').val('');
                $('#km_inicial').val('');
                $('#id_vehiculo').val('0');
                $('#km_final').val('');
                $('#km_recorridos').val('');
                $('#casetas').val('');
                $('#combustible').val('');
                $('#tipo_gasolina').val('');
                $('#id_departamentos').selectpicker('val', '');
                $('.inputs_vehiculo_comision').hide();
                $('#alert_error_2').show();
            } 
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**Funcion para obtener los kilometros recorridos del vehiculo------------- */
function Obtener_km_recorridos(){
    var inicio = parseFloat($('#km_inicial').val().trim()) || 0;
    var fin = parseFloat($('#km_final').val().trim()) || 0;
    var url = $('#url_suma_kilometros').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: { inicio:inicio, fin:fin },
        success: function (data) {
            var valcor = JSON.parse(data);
            var km_recorrido = valcor[0];
            if(km_recorrido >= 0){
                $('#km_recorridos').val(km_recorrido);
            }else{
                swal({
                    title: '¡Error!',
                    text: 'El Kilometraje Final tiene que ser mayor al Kilometraje Inicial',
                    type: 'error',
                    /*showConfirmButton: false,
                    timer: 1500*/
                })
                $('#km_final').val('');
                $('#km_recorridos').val('');
            }
            
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**---Funcion para modificar el compacto----------------------------------- */
function Actualizar_compacto_comision(id){
    $('#form_compacto_comision')[0].reset();
    var url = $('#url_modificar').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: {id:id},
        success:function(data){
            var cachetonypolar = JSON.parse(data);
            $('#proceso').val('Edicion');
            $('#id').val(cachetonypolar[0]);
            $('#id_vehiculo').val(cachetonypolar[1]);
            $('#id_comisiones').selectpicker('val', cachetonypolar[2]);
            $('#km_inicial').val(cachetonypolar[3]);
            $('#km_final').val(cachetonypolar[4]);
            $('#km_recorridos').val(cachetonypolar[5]);
            $('#casetas').val(cachetonypolar[6]);
            $('#combustible').val(cachetonypolar[7]);
            $('#tipo_gasolina').val(cachetonypolar[8]).change();
            $('#id_departamentos').selectpicker('val', cachetonypolar[9]).change();
            $('#nombre_vehiculo').val(cachetonypolar[10]);
            //$('#input_km_inicial').hide();
            //$('#input_km_2').show();
            $('#alert_error').hide();
            $('#alert_error_2').hide();
            $('#btn_registrar').hide();
            $('#btn_actualizar').show();
            $('#modal_compacto_comision_label').html("Actulizar Compacto Comisión");
            $('#modal_compacto_comision').modal('show');
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-----Funcion para eliminar el compacto de comisiones-------------------- */
function Eliminar_compacto_comision(ideliminar){
    var url = $('#url_paginar').val();
    var dato = '';
    var partida = '1';

    swal({
        title: "Eliminar Comisión?",
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
/**--------Funcion para mostar el catalogo de las comisiones--------------- */
function Pagination_catalogo_comsiones(partida){
    var url = $('#url_paginar').val();
    var fecha_inicial = $('#fInicio').val();
    var fecha_final = $('#fFin').val();
    $.ajax({
        type:'POST',
        url:url,
        data:{partida:partida, fecha_inicial:fecha_inicial, fecha_final:fecha_final},
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
/**-------Funcion para mostar el modal de los pagos------------------------ */
function Modal_configuracion_pago(){
    $('#form_pagos')[0].reset();
    $('#proceso_pagos').val('Registro');
    $('btn_agregar_pagos').show();
    $('#btn_actualizar_pagos').hide();
    $('#modal_pagos_label').html("Registrar Pago(s)");
    $('#modal_pagos').modal('show');
    return false;
};
/**------------------------------------------------------------------------ */
/**-------Función para descargar la plantilla de excel--------------------- */
function Descargar_plantilla_pagos(){
    var url = $('#url_descargar_plantilla_pagos').val();
    $.ajax({
        url: url,
        method: 'GET',
        xhrFields: {
            responseType: 'blob' //Indica que se espera un blob
        },
        success: function(data){
            //crea un enlace temporal para descargar el archivo
            const url = window.URL.createObjectURL(new Blob([data]));
            const a = document.createElement('a');
            a.href = url;
            a.download = 'plantilla_pagos.xlsx'    //nombre del archivo
            document.body.appendChild(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);// Libera la URL del blob
            $('#modal_pagos').modal('toggle');
            swal({
                title: 'Proceso Terminado',
                text: 'Archivo Descargado Correctamente',
                type: 'success',
                showConfirmButton: false,
                timer: 1500
            })
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.error('Error al descargar el archivo: ', textStatus, errorThrown);
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Ocurrio un error en la descargar, Intentelo nuevamente!"
            });
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**-------Funcion para la paginación de los pagos-------------------------- */
function Pagination_pagos(partida){
    var url = $('#url_paginar').val();
    var dato = $('#busqueda').val();
    var ideliminar = '0';
    $.ajax({
        type: 'POST',
        url: url,
        data:{ideliminar:ideliminar, dato:dato, partida:partida},
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
/**-------Función para registrar los pagos de manera masiva---------------- */
function Registrar_pagos(){
    var archivoPagos = $('#archivo_pagos').val();
    if(archivoPagos == ""){
        swal({
            title: 'Incorrecto',
            text: 'Tiene que seleccionar un archivo',
            type: 'error',
            showConfirmButton: true
        });
        return false;
    }else{
        var formPago = new FormData($("#form_pagos")[0]);
        //Deshabilitar el boton de envio durante el mismo
        $('#btn_agregar_pagos').prop('disabled', true);
        $('#btn_agregar_pagos').html('<span class="spinner-grow spinner-grow-sm text-light" aria-hidden="true"></span><span role="status"> Cargando...</span>');
        $('#progress-container').show(); //Mostramos el contenedor de progreso
        $.ajax({
            type: 'POST',
            url: $('#form_pagos').attr('action'),
            data: formPago,
            processData: false,
            contentType: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                
                // Escuchar el evento de progreso
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded / evt.total) * 100); // Porcentaje completado
    
                        // Mostrar el progreso en la barra y en el texto dentro de la barra
                        $('#progress-bar').css('width', percentComplete + '%'); // Actualizar la barra de progreso
                        $('#progress-bar').attr('aria-valuenow', percentComplete); // Actualizar el valor aria
                        $('#progress-percent').text(percentComplete + '%'); // Mostrar el porcentaje dentro de la barra
                        $('#progress-container').show(); // Asegurarse de que la barra de progreso esté visible
                    }
                }, false);
                
                return xhr;
            },
            beforeSend: function() {
                // Reiniciar la barra de progreso y mostrar el mensaje de carga
                $('#progress-container').show();
                $('#progress-bar').css('width', '0%');
                $('#progress-bar').attr('aria-valuenow', '0');
                $('#progress-percent').text('0%');
                $('#status-text').text('Cargando archivo...').show(); // Mostrar el mensaje de carga
            },
            success:function(data){
                var array = JSON.parse(data);
                var comprobar = array[0];
                $('#btn_agregar_pagos').prop('disabled', false); //habilitar el boton de envio ddespues de la carga del archivo
                $('#btn_agregar_pagos').html('Registrar');//Regresamos el button a la normalidad
                //$('#progress-container').hide();//Ocultamos el contenedor de la barra de progreso
                setTimeout(function(){
                    $('#progress-container').hide();//ocultar la barra de progreso
                },2000);//esperar dos segundos
                if($('#proceso_pagos').val() == 'Registro'){
                    switch (comprobar){
                        case "0":
                            $('#modal_pagos').modal('toggle');
                            $('#form_pagos')[0].reset();
                            swal({
                                title: 'Correcto',
                                text: 'Registros Almacenados con Éxito',
                                type: 'success',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            Pagination_pagos(1);
                            return false;
                        break;
                        case "1":
                            swal({
                                title: 'Incorrecto',
                                text: 'Solo se admiten archivos .XLSX!',
                                type: 'error',
                                showConfirmButton: true
                            });
                            $('#form_pagos')[0].reset();
                            return false;
                        break;
                        case "2":
                            swal({
                                title: 'Incorrecto',
                                text: 'Hubo un error en la carga del archivo, intente nuevamente',
                                type: 'error',
                                showConfirmButton: true
                            });
                            $('#form_pagos')[0].reset();
                            return false;
                        break;
                        default:
                            swal({
                                title: 'Incorrecto',
                                text: 'Hubo un error en la subida de información, intente nuevamente',
                                type: 'error',
                                showConfirmButton: true
                            });
                            $('#form_pagos')[0].reset();
                            return false;
                    }
                }
            }    
        });
    }
    return false;
};
/**------------------------------------------------------------------------ */
/**-------Funcion para mostrar el detalle de cada Pago almacenado---------- */
function Examina_detalle_pago(idpago){
    $('#contenido_pagina').load("modulos/detalle_pago.php", function Detalle_procesado_pago(){
        var url = "php/pagos/consulta_detalle_pago.php";
        $.ajax({
            type: 'POST',
            url: url,
            data:{idpago: idpago},
            success:function(data){
                var polarcito = JSON.parse(data);
                $('#detalle_del_pago').html(polarcito[0]);
                $('#x_pago').val(polarcito[2]);
                Pagination_detalles_pago(1);//llamamos a la funcion para que cargue cuando ya exista el valor de x_pago
                return false;
            }
        });
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**----Funcion para paginar el detalle de pagos --------------------------- */
function Pagination_detalles_pago(partida){
    var url = $('#url_paginar').val();
    //var dato = $('#select_busqueda_detalle_pago').val();
    var id_pago = $('#x_pago').val();
    var ideliminar = '0';
    $.ajax({
        type:'POST',
        url:url,
        data:{partida:partida, ideliminar:ideliminar, id_pago: id_pago},
        success:function(data){
            var array = eval(data);
            $('#agrega-registros').html(array[0]);
            $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
            /*$('#pagination_info').html(array[1]);
            $('#pagination').html(array[2]);
            
            if(dato > 0){
                $('#buscar_detalle_pago')[0].reset();
            }*/
            return false;
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**--------Funcion para el modal del detalle de pago*-*-------------------- */
function Modal_configuracion_detalle_pago(){
    $('#form_detalle_pago')[0].reset();
    $('#id_departamentos').selectpicker('val', '');
    $('#proceso_detalle_pago').val('Registro');
    $('#btn_agregar_detalle_pago').show();
    $('#btn_actualizar_detalle_pago').hide();
    $('#aler_detalle_pago').hide();
    $('#modal_detalle_pagos_label').html('Registrar Nuevo Detalle de Pago');
    $('#modal_detalle_pagos').modal('show');
    return false;
};
/**------------------------------------------------------------------------ */
/**Nuevas Funciones para Registrar el Detalle de Pago---------------------- */
function mostrarMensaje(comprobar, accion) {
    if (comprobar == 0) {
        $('#modal_detalle_pagos').modal('toggle');
        swal({
            title: 'Proceso Terminado',
            text: accion === 'Registro' ? 'Registro Agregado Correctamente' : 'Registro Actualizado con Éxito',
            type: 'success',
            showConfirmButton: false,
            timer: 1500
        });
        Pagination_detalles_pago(1);
        return false;
    } else if (comprobar == 1) {
        $('#aler_detalle_pago').show();
        $('#monto_detalle_pago').val('');
        return false;
    } 
}
/***----------------------------------------------------------------------- */
function Registrar_detalle_pago(){
    var monto_detalle = $('#monto_detalle_pago').val();
    var departamento = $('#id_departamentos').val();
    var regex = /^\d{1,10}(\.\d{0,2})?$/;

    if(monto_detalle === ''){
        swal({
            title: 'Incorrecto',
            text: 'El Monto del Detalle Pago es obligatorio',
            type: 'error',
            showConfirmButton: true
        });
        return false;
    } else if(!regex.test(monto_detalle)){
        swal({
            title: 'Incorrecto',
            text: 'Solo se admiten un total de 10 números antes del punto decimal y solo 2 decimales',
            type: 'error',
            showConfirmButton: true
        });
        $('#monto_detalle_pago').val('');
        return false;
    } else if(departamento === ''){
        swal({
            title: 'Incorrecto',
            text: 'Seleccione un departamento, es obligatorio',
            type: 'error',
            showConfirmButton: true
        });
        return false;
    } else {
        var form_detalle_pago = $('#form_detalle_pago').serializeArray(); 
        var id_pago_padre = $('#x_pago').val();
        form_detalle_pago.push({ name: 'id_pago_padre', value: id_pago_padre });

        $.ajax({
            type: 'POST',
            url: $('#form_detalle_pago').attr('action'),
            data: form_detalle_pago,
            success: function(data) {
                var array = JSON.parse(data);
                var comprobar = array[0];
                var accion = $('#proceso_detalle_pago').val();  // 'Registro' o 'Actualización'
                mostrarMensaje(comprobar, accion);  // Pasamos el valor de 'Registro' o 'Actualización'
            }
        });
    }
    return false;
}
/**------------------------------------------------------------------------ */
/*Funcion para manejar el Registro/Eliminacion de los PE de detalle de pagos */
function Manejar_pe_detalle_pago(id_pago, isChecked) {
    var url = $('#form_pe_pagos').attr('action');
    var mensaje = isChecked ? "Registrar los P.E.?" : "Eliminar los P.E.?";
    var confirmText = isChecked ? "Confirmar!" : "Confirmar!";
    var nuevoEstado = isChecked ? 0 : 1;

    Swal({
        title: mensaje,
        text: "El registro se modificará de forma permanente.",
        icon: "warning", // Cambiado de 'type' a 'icon'
        showCancelButton: true,
        confirmButtonColor: "#DD6D55",
        confirmButtonText: confirmText,
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: url,
                data: { id_pago: id_pago, nuevoEstado: nuevoEstado },
                success: function(data) {
                    var respuesta = JSON.parse(data);
                    if (respuesta[0] == 0) {
                        Pagination_pagos(1);
                        Swal({
                            title: "Proceso Terminado",
                            text: "Registro Modificado con Éxito",
                            icon: "success", // Cambiado de 'type' a 'icon'
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal("Ocurrió un error", "Inténtelo nuevamente", "error");
                    }
                },
                error: function() {
                    Swal("Error", "No se pudo completar la solicitud", "error");
                }
            });
        } else {
            Pagination_pagos(1);
            Swal("Proceso Cancelado", "No se ha efectuado ningún cambio", "info");
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**----------Funcion para paginar los ejercicios fiscales------------------ */
function Pagination_ejercicio_fiscal(partida){
    var url = $('#url_ejercicio_fiscal').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: {partida:partida},
        success:function(cachetoncito){
            //Limpiar las opciones del select
            $('#ejercicio_fiscal').empty();
            //Añadir las nuevas opciones
            $('#ejercicio_fiscal').append(cachetoncito);
            //Volver a iniciar el selectpicker
            // Aquí se puede intentar 'destroy' y luego volver a inicializar para evitar problemas con duplicados
            $('#ejercicio_fiscal').selectpicker('destroy').selectpicker();
            return false;
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log("Error en la solicitud AJAX: " + textStatus + " - " + errorThrown);
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**----Funcion para obtener la paginacion de los ejercicios fiscales -------*/
function Pagination_historico_documentos(partida) {
    var url = $('#url_paginar').val();
    var anio = $('#ejercicio_fiscal').val();
    var inputBuscar = $('#inputBuscar').val();
    if (!url || !anio) {
        /*swal({
            type: 'warning',
            title: 'Datos incompletos',
            text: 'Asegúrate de seleccionar un ejercicio fiscal correctamente.',
        })*/
        $('#alert_vacio_ejercicio').show();
        return false;
    }
    
    // Muestra el cargando
    swal({
        title: 'Cargando...',
        allowOutsideClick: false,
        showConfirmButton: false,  // Oculta el botón de confirmación
        text: 'Por favor espera...',
    });

    $.ajax({
        type: 'POST',
        url: url,
        data: { partida: partida, anio: anio, inputBuscar: inputBuscar},
        dataType: 'json',
        success: function (bebelogan) {
            if (bebelogan && bebelogan.length) {
                setTimeout(() => {
                    $('#alert_vacio_ejercicio').hide();
                    $('#agrega-registros').html(bebelogan[0]);
                    $('#pagination_info').html(bebelogan[1]);
                    $('#pagination').html(bebelogan[2]);
                    $('#inputBuscar').prop("disabled", false);
                
                    // Cambiar el contenido de la alerta de "Cargando..." a la de éxito
                    swal({
                        type: "success",
                        title: "Registros encontrados",
                        text: 'Los registros han sido cargados exitosamente.',
                        showConfirmButton: false,
                        timer: 1500  // Se cierra automáticamente después de 1.5 segundos
                    });
                    $('[data-bs-toggle="tooltip"]').tooltip(); // Inicializa todos los tooltips
                    
                }, 1000);
            }
        },
        error: function () {
            setTimeout(() => {
                // Mostrar un mensaje de error y luego ocultarlo
                swal({
                    type: 'error',
                    title: '¡Error!',
                    text: 'Hubo un problema al procesar tu solicitud. Intenta nuevamente.',
                    confirmButtonText: 'Cerrar'
                });
            }, 1000);
        }
    });

    return false;
}


/**------------------------------------------------------------------------ */
/***Descargar documentos--------------------------------------------------- */
function Descargar_documento_h(id, anio) {
    var url = $('#url_descargar_documento_h').val();
    $.ajax({
        type: 'POST',
        url: url,
        data: { id: id, anio:anio},
        success: function (data) {
            if (data !== '') {
                // Construir la URL de descarga directa
                var url = '/itsa/virtual/documentos/' + data;
                //window.location.href = url;
                window.open(url, '_blank');
            } else {
                console.log("No se pudo obtener el nombre del archivo.");
            }
        },
        error: function(error){
            // Manejar el error aquí
            console.error("Error en la solicitud Ajax:", error);
        }
    });
    return false;
};
/**------------------------------------------------------------------------ */
/**---------------------------Historial documentos---------------------------- */
function Historial_documento_h(id, anio){
    var url = $('#url_historial_documento_h').val();
    $.ajax({
        type: 'POST',
        url: url,
        data:{id:id, anio:anio},
        success:function(data){
            var valcor = JSON.parse(data);
            $('#historial_documentos_table').html(valcor[0]);
            $('#modal_historial_documento_label').html("Historial de Movimientos");
            $('#modal_historial_documento').modal('show');
        }
    });
    return false;
};
/**------------------------------------------------------------------------ 
function Historial_documento_timeline(id, anio){
    $('#contenido_pagina').load("modulos/historico_historial_documento.php", function Detalle_procesado_pago(){
        var url = "php/historico_documentos/consulta_historial_documento.php";
        $.ajax({
            type: 'POST',
            url: url,
            data:{id: id, anio:anio},
            success:function(data){
                var polarcito = JSON.parse(data);
                $('#detalle_del_historial').html(polarcito[0]);
                $('#x_id_historial').val(polarcito[1]);
                $('#x_anio_historial').val(polarcito[2]);
                Pagination_historial_timeline();//llamamos a la funcion para que cargue cuando ya exista el valor de x_pago
                return false;
            }
        });
    });
    return false;
};/*
function Pagination_historial_timeline(){
    var url = $('#url_paginar').val();
    var id = $('#x_id_historial').val();
    var anio = $('#x_anio_historial').val();
    $.ajax({
        type:'POST',
        url:url,
        data:{id:id, anio:anio},
        success:function(data){
            var array = eval(data);
            $('#agrega-registros').html(array[0]);
            return false;
        }
    });
    return false;
};*/