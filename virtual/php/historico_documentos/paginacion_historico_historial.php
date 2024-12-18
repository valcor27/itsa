<?php
require("../conexion/conexion_bd.php");
require("../sesion/logueo.php");
require("../clases/limpiar.php");
$id_documento = $_POST["id"];
$anio_documento = $_POST["anio"];
$tabla = '
   <h1>Responsive Timeline using Flexbox</h1>
   <div class="timeline">
      <div class="timeline-item">
         <div class="timeline-date">
            <img src="img/file_earmark.svg"/>
            <div>
               January 2019
            </div>
         </div>
         <div class="timeline-content">
            <h2>Journey Start <span>(Delhi)</span></h2>
            <p>
               Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad saepe nulla quibusdam ut. Beatae, facere sequi blanditiis porro suscipit tempore ipsam iste ipsa, culpa quam vero, dolorem cupiditate. Magni, numquam?
               <button type="button" class="visit">
                  Visit ›
               </button>
               <img src="img/file_earmark.svg"/>
            </p>
            <br>
         </div>
      </div>
      <div class="timeline-item">
         <div class="timeline-date">
            <img src="img/file_earmark.svg"/>
            <div>
               February 2019
            </div>
         </div>
         <div class="timeline-content">
            <h2>Nawabo ka Sehar<span>(Lucknow)</span></h2>
            <p>
               Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad saepe nulla quibusdam ut. Beatae, facere sequi blanditiis porro suscipit tempore ipsam iste ipsa, culpa quam vero, dolorem cupiditate. Magni, numquam?
               <button type="button" class="visit">
                  Visit ›
               </button>
               <img src="img/file_earmark.svg"/>
            </p>
            <br>
         </div>
      </div>
      <div class="timeline-item">
         <div class="timeline-date">
            <img src="img/file_earmark.svg"/>
            <div>
               March 2019
            </div>
         </div>
         <div class="timeline-content">
            <h2>Devotional Place<span>(Prayagraj)</span></h2>
            <p>
               Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad saepe nulla quibusdam ut. Beatae, facere sequi blanditiis porro suscipit tempore ipsam iste ipsa, culpa quam vero, dolorem cupiditate. Magni, numquam?
               <button type="button" class="visit">
                  Visit ›
               </button>
               <img src="img/file_earmark.svg"/>
            </p>
            <br>
         </div>
      </div>
   </div>
';
$array = array(
   0 => $tabla
);
echo json_encode($array);
mysqli_close($conexion_database);