<?php require("../php/sesion/logueo.php") ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> CONTROL DE GESTIÓN</title>
</head>
<body>
    <main id="contenido_pagina" class="container">
        <div class="container">
            <div class="w-100">
                <div class="row mt-5">
                    <div class="d-flex col-xxl-3 col-lg-3 col-sm-12">
                        <div class="flex-fill card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="mt-0 col">
                                        <h5 class="card-title">Documentos de Subdirección de Servicios Administrativos</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat stat-sm">
                                            <i class="fa-regular fa-file icon-dash"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="h1 d-inline-block mt-1 mb-4">
                                    100
                                </span>
                                <div class="mb-0">
                                    <span class="badge-soft-success me-2 badge">
                                        100%
                                    </span>
                                    <span class="text-muted">
                                        Documentos Aceptados
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="d-flex col-xxl-3 col-lg-3 col-sm-12">
                        <div class="flex-fill card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="mt-0 col">
                                        <h5 class="card-title">Documentos de Personal</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat stat-sm">
                                            <i class="fa-regular fa-file icon-dash"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="h1 d-inline-block mt-1 mb-4">
                                    90
                                </span>
                                <div class="mb-0">
                                    <span class="badge-soft-success me-2 badge">
                                        75%
                                    </span>
                                    <span class="text-muted">
                                        Documentos Aceptados
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="d-flex col-xxl-3 col-lg-3 col-sm-12">
                        <div class="flex-fill card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="mt-0 col">
                                        <h5 class="card-title">Documentos de Recursos Financieros</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat stat-sm">
                                            <i class="fa-regular fa-file icon-dash"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="h1 d-inline-block mt-1 mb-4">
                                    36
                                </span>
                                <div class="mb-0">
                                    <span class="badge-soft-success me-2 badge">
                                        80%
                                    </span>
                                    <span class="text-muted">
                                        Documentos Aceptados
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="d-flex col-xxl-3 col-lg-3 col-sm-12">
                        <div class="flex-fill card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="mt-0 col">
                                        <h5 class="card-title">Documentos de Recursos Materiales y de Servicios</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat stat-sm">
                                            <i class="fa-regular fa-file icon-dash"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="h1 d-inline-block mt-1 mb-4">
                                    16
                                </span>
                                <div class="mb-0">
                                    <span class="badge-soft-success me-2 badge">
                                        20%
                                    </span>
                                    <span class="text-muted">
                                        Documentos Aceptados
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div> 
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="flex-fill card">
                            <div class="card-body">
                                <canvas id="bar_documentos"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="flex-fill card">
                            <div class="card-body">
                                <canvas height="250" id="donut_documentos"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="flex-fill card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-0 card-title h5">
                                            <i class="fa-solid fa-file-lines"></i> Registro de Documentos
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="card-actions float-end">
                                            <button type="button" class="btn btn-primary">
                                                <i class="fa-solid fa-file-export"></i> Generar Reporte
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Concepto</th>
                                            <th>Fecha</th>
                                            <th>Solicitante</th>
                                            <th>Estatus</th>
                                        </tr>  
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>SSA/MLGM/001</td>
                                            <td>Pago Materiales</td>
                                            <td>10/08/2023</td>
                                            <td>Norma Ángelica Luna González</td>
                                            <td>
                                                <span class="badge text-bg-success">Aceptado</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>SSA/MLGM/001</td>
                                            <td>Pago Materiales</td>
                                            <td>10/08/2023</td>
                                            <td>Norma Ángelica Luna González</td>
                                            <td>
                                                <span class="badge text-bg-danger">Cancelado</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>SSA/MLGM/001</td>
                                            <td>Pago Materiales</td>
                                            <td>10/08/2023</td>
                                            <td>Norma Ángelica Luna González</td>
                                            <td>
                                                <span class="badge text-bg-warning">En progreso</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>SSA/MLGM/001</td>
                                            <td>Pago Materiales</td>
                                            <td>10/08/2023</td>
                                            <td>Norma Ángelica Luna González</td>
                                            <td>
                                                <span class="badge text-bg-success">Aceptado</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>SSA/MLGM/001</td>
                                            <td>Pago Materiales</td>
                                            <td>10/08/2023</td>
                                            <td>Norma Ángelica Luna González</td>
                                            <td>
                                                <span class="badge text-bg-danger">Cancelado</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>SSA/MLGM/001</td>
                                            <td>Pago Materiales</td>
                                            <td>10/08/2023</td>
                                            <td>Norma Ángelica Luna González</td>
                                            <td>
                                                <span class="badge text-bg-warning">En progreso</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>SSA/MLGM/001</td>
                                            <td>Pago Materiales</td>
                                            <td>10/08/2023</td>
                                            <td>Norma Ángelica Luna González</td>
                                            <td>
                                                <span class="badge text-bg-success">Aceptado</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>SSA/MLGM/001</td>
                                            <td>Pago Materiales</td>
                                            <td>10/08/2023</td>
                                            <td>Norma Ángelica Luna González</td>
                                            <td>
                                                <span class="badge text-bg-danger">Cancelado</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>SSA/MLGM/001</td>
                                            <td>Pago Materiales</td>
                                            <td>10/08/2023</td>
                                            <td>Norma Ángelica Luna González</td>
                                            <td>
                                                <span class="badge text-bg-warning">En progreso</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main> 
    <script src="js/dashboard_ssa.js"></script>
</body>
</html>