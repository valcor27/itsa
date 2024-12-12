<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CONTROL DE GESTIÓN</title>
  <link rel="stylesheet" href="virtual/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="virtual/css/estilos.css">
  <link rel="stylesheet" href="virtual/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="virtual/sweetalert/css/sweetalert.css">
  <style>
          body, html {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .bg-image {
            background-image: url('virtual/img/itsa2.jpg'); /* Ruta de tu imagen */
            background-size: cover; /* Cubrir toda la pantalla */
            background-position: center; /* Centrar la imagen */
            position: relative;
            height: 100vh;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Color oscuro con opacidad */
        }
    </style>
</head>
<body>
  <!--<header>
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="virtual/img/logo.png" alt="LOGO"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">nosotros</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-outline-danger" href="#" onclick="return Modal_iniciar_sesion();">iniciar sesión</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>--> 
  <div class="bg-image">
    <div class="overlay"></div>
    <main class="vh-100 d-flex justify-content-center align-items-center">
      <div class="container">
        <div class="row justify-content-center">
          <!--<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
            <div id="Inicio" class="carousel slide carousel-fade" data-bs-ride="carousel">
              <div class="carousel-indicators">
                <button type="button" data-bs-target="#Inicio" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#Inicio" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#Inicio" data-bs-slide-to="2" aria-label="Slide 3"></button>
              </div>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="virtual/img/img1.jpg" class="d-block w-100" alt="IMAGEN 1">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>Primera imagen</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                  </div>
                </div>
                <div class="carousel-item">
                  <img src="virtual/img/img2.jpg" class="d-block w-100" alt="IMAGEN 2">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>Segunda imagen</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                  </div>
                </div>
                <div class="carousel-item">
                  <img src="virtual/img/img3.jpg" class="d-block w-100" alt="IMAGEN 3">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>Tercera imagen</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                  </div>
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#Inicio" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#Inicio" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>-->
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card bg-transparent border-light mb-3 mx-auto" style="max-width: 18rem;">
              <div class="card-header bg-transparent border-light d-flex justify-content-center">
                <img class="logo-index" src="virtual/img/logo_blanco.png" alt="LOGO">
              </div>
              <form id="formulario_sesion" onsubmit="return Inicio_sesion();">
                <input type="hidden" id="url_inicio_sesion" value="virtual/php/sesion/inicio_sesion.php">
                <div class="card-body text-light">
                  <h5 class="card-title text-light">INICIAR SESIÓN</h5>
                    <div class="row justify-content-center">
                      <div class="col-md-12">
                        <div class="input-group mb-3">
                          <span class="input-group-text"><i class="fa-solid fa-circle-user"></i></span>
                          <input type="text" id="expediente" name="expediente" class="form-control" placeholder="Expediente" aria-label="Expediente" aria-describedby="basic-addon1" required="">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="input-group mb-3">
                          <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                          <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="Contraseña" aria-label="Contraseña" aria-describedby="basic-addon1" required="">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="alert alert-primary" role="alert" id="validar_sesion">
                          <i class="fa-solid fa-circle-info"></i> Verificando datos!
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="alert alert-danger" role="alert" id="error_sesion">
                          <i class="fa-solid fa-xmark"></i> Usuario o contraseña incorrectos!
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="alert alert-info" role="alert" id="info_sesion">
                          <i class="fa-solid fa-circle-info"></i> Si no tiene cuenta solicitela a Subdirección de Servicios Administrativos.
                        </div>
                      </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-light d-flex justify-content-end">
                  <button type="submit" class="btn btn-success">Aceptar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main><!--
  <div class="modal fade" id="modallogin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="modalloginLabel">INICIAR SESIÓN</h6>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="formulario_sesion" onsubmit="return Inicio_sesion();">
        <input type="hidden" id="url_inicio_sesion" value="virtual/php/sesion/inicio_sesion.php">
          <div class="modal-body">
            <div class="row justify-content-center">
              <div class="col-md-12">
                <div class="input-group mb-3">
                  <span class="input-group-text"><i class="fa-solid fa-circle-user"></i></span>
                  <input type="text" id="expediente" name="expediente" class="form-control" placeholder="Expediente" aria-label="Expediente" aria-describedby="basic-addon1" required="">
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-3">
                  <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                  <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="Contraseña" aria-label="Contraseña" aria-describedby="basic-addon1" required="">
                </div>
              </div>
              <div class="col-md-12">
                <div class="alert alert-primary" role="alert" id="validar_sesion">
                  <i class="fa-solid fa-circle-info"></i> Verificando datos!
                </div>
              </div>
              <div class="col-md-12">
                <div class="alert alert-danger" role="alert" id="error_sesion">
                  <i class="fa-solid fa-xmark"></i> Usuario o contraseña incorrectos!
                </div>
              </div>
              <div class="col-md-12">
                <div class="alert alert-info" role="alert" id="info_sesion">
                  <i class="fa-solid fa-circle-info"></i> Si no tiene cuenta solicitela a Subdirección de Servicios Administrativos.
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-success">Aceptar</button>
          </div>
        </form>
      </div>
    </div>
  </div>-->
  </div>
  <script src="virtual/jquery/jquery.min.js"></script>
	<script src="virtual/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="virtual/fontawesome/js/all.min.js"></script>
	<script src="virtual/sweetalert/js/sweetalert.min.js"></script>
	<script src="virtual/js/componentes.js"></script>
  <script>
    $('#formulario_sesion')[0].reset();
    $('#error_sesion').hide();
    $('#validar_sesion').hide();
    $('#info_sesion').show();
  </script>
</body>
</html>