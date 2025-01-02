<?php require("../php/sesion/logueo.php") ?>
<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>CONTROL DE GESTIÓN</title>
</head>

<body>
   <input type="hidden" id="url_paginar" name="url_paginar" value="php/historico_documentos/paginacion.php">
   <input type="hidden" id="url_ejercicio_fiscal" name="url_ejercicio_fiscal" value="php/historico_documentos/ejercicio_fiscal.php">
   <input type="hidden" id="url_historial_documento_h" name="url_historial_documento_h" value="php/historico_documentos/historico_historial_documento.php">
   <input type="hidden" id="url_descargar_documento_h" name="url_descargar_documento_h" value="php/historico_documentos/descargar_documento_h.php">
   <main id="contenido_pagina">
      <div class="container mt-5">
         <div class="wrraper">
            <div class="row">
               <div class="col-sm-12">
                  <div class="card my-4">
                     <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 ">
                           <div class="row justify-content-center">
                              <div class="col-auto align-items-center">
                                 <h6 class="text-white ps-3 title-pagina"><i class="fa-solid fa-clock-rotate-left"></i> módulo historico de documentos</h6>
                              </div>
                           </div>
                           <div class="row justify-content-between">
                              <div class="col">
                                 <form id="buscar" name="buscar" onsubmit=" return Pagination_historico_documentos(1);">
                                    <div class="row justify-content-center align-items-center">
                                       <div class="col">
                                          <div class="input-group mb-3 ps-3" id="select_ejercicio_fiscal_historico">
                                             <span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
                                             <select class="selectpicker form-control" title="Selecciona un Ejercicio Fiscal" data-live-search="true" name="ejercicio_fiscal" id="ejercicio_fiscal" required="" onchange="return Pagination_historico_documentos(1);"></select>
                                          </div>
                                       </div>
                                       <div class="col">
                                          <div class="input-group mb-3 ps-3" id="select_ejercicio_fiscal_historico">
                                             <input type="text" id="inputBuscar" class="form-control" placeholder="Buscar por folio, asunto o fecha" disabled>
                                             <button class="btn btn-outline-light" id="datepickerToggle" type="button">
                                                <i class="fa-solid fa-calendar-day"></i>
                                             </button>
                                          </div>
                                       </div>
                                       <div class="col">
                                          <div class="mb-3 ps-3">
                                             <button class="btn btn-outline-light" type="submit" id="button-addon2">Buscar</button>
                                          </div>
                                       </div>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="container">
                        <div class="card-body px-0 pb-2">
                           <div class="card mb-4">
                              <div class="card-header cheader">
                                 <i class="fas fa-folder-open"></i>
                                 Listado de Registros
                              </div>
                              <div class="card-body">
                                 <div id="agrega-registros">
                                    <div class="alert alert-info" id="alert_vacio_ejercicio">
                                       <strong>Mensaje!</strong> Selecciona al menos un <strong>Ejercicio Fiscal</strong>, para obtener resultados.
                                    </div>
                                 </div>
                              </div>
                              <div class="card-footer text-muted">
                                 <div class="row">
                                    <div class="col-sm-6">
                                       <div id="pagination_info">Datos Paginas</div>
                                    </div>
                                    <div class="col-sm-6 d-flex justify-content-end">
                                       <nav aria-label="Page navigation example">
                                          <div id="pagination">No. de paginas</div>
                                       </nav>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade" id="modal_historial_documento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_historial_documento_label" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <h6 class="modal-title" id="modal_historial_documento_label"></h6>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body" id="historial_documentos_table">
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade" id="modal-timeline" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_timeline_label" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <h6 class="modal-title" id="modal_timeline_label"></h6>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <div class="container my-5">
                     <div class="row">
                        <div class="col-md-6 offset-md-3">
                           <h4 style="margin-left: 1.2rem;">Latest News</h4>
                           <ul class="timeline-3">
                              <li>
                                 <a href="#!">New Web Design</a>
                                 <a href="#!" class="float-end">21 March, 2014</a>
                                 <p class="mt-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque scelerisque diam
                                    non nisi semper, et elementum lorem ornare. Maecenas placerat facilisis mollis. Duis sagittis
                                    ligula in sodales vehicula....</p>
                              </li>
                              <li>
                                 <a href="#!">21 000 Job Seekers</a>
                                 <a href="#!" class="float-end">4 March, 2014</a>
                                 <p class="mt-2">Curabitur purus sem, malesuada eu luctus eget, suscipit sed turpis. Nam pellentesque
                                    felis vitae justo accumsan, sed semper nisi sollicitudin...</p>
                              </li>
                              <li>
                                 <a href="#!">Awesome Employers</a>
                                 <a href="#!" class="float-end">1 April, 2014</a>
                                 <p class="mt-2">Fusce ullamcorper ligula sit amet quam accumsan aliquet. Sed nulla odio, tincidunt
                                    vitae nunc vitae, mollis pharetra velit. Sed nec tempor nibh...</p>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
               </div>
            </div>
         </div>
      </div>
   </main>
   <script>
      $(document).ready(function() {
         Pagination_ejercicio_fiscal(1);
         Pagination_historico_documentos(1);
         //inicializar el datepicker
         $("#inputBuscar").datepicker({
            language: 'es',
            format: 'dd-mm-yyyy',
            autoclose: true,
            clearBtn: true,
            todayHighlight: true,
            showOnFocus: false,
         });
         //mostrar datepicker al hacer clic en el boton
         $('#datepickerToggle').on('click', function() {
            $('#inputBuscar').datepicker('show');
         });
         //deshabilitar datepicker temporalmente al escribir o pegar
         $("#inputBuscar").on('keydown paste', function(){
            $(this).datepicker('destroy'); //desactiva temporalmente el datepicker
         });
         $("#inputBuscar").on('blur', function(){
               $(this).datepicker({
               language: 'es',
               format: 'dd-mm-yyyy',
               autoclose: true,
               clearBtn: true,
               todayHighlight: true,
               showOnFocus: false,
            });
         });
      });
   </script>
</body>

</html>