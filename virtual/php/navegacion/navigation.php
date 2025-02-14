<?php
require 'php/sesion/logueo.php';
if ($nivel_sesion == 1 && $estructura_real == 10000) {/* DG*/ ?>
	<li class="list-header">INICIO</li>
	<li class="nav-item">
		<a href="index.php" id="jsp_inicio" class="nav-link active">
			<i class="fa-solid fa-house-chimney"></i>
			<span class="menu-title">Inicio</span>
		</a>
	</li>
	<li class="list-header">DASHBOARD</li>
	<li class="nav-item">
		<a href="#" id="jsp_dash_dg" class="nav-link">
			<i class="fa-solid fa-chart-line"></i>
			<span class="menu-title">Dashboard</span>
		</a>
	</li>
	<li class="list-divider-sdd"></li>
	<li class="list-header">SUBDIRECCIÓN DE SERVICIOS ADMINISTRATIVOS</li>
	<li class="nav-item">
		<a href="#" id="jsp_dash_ssa" class="nav-link">
			<i class="fa-solid fa-chart-line"></i>
			<span class="menu-title">Dashboard</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_usuarios_ssa" class="nav-link">
			<i class="fa-regular fa-user"></i>
			<span class="menu-title">Usuarios</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_documentos" class="nav-link">
			<i class="fa-solid fa-file-lines"></i>
			<span class="menu-title">Documentos</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_catalogo_comisiones" class="nav-link">
			<i class="fa-solid fa-route"></i>
			<span class="menu-title">Comisiones Realizadas</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="list-header">Departamento de Personal</li>
	<li class="nav-item">
		<a href="#" id="jsp_edificio" class="nav-link">
			<i class="fa-regular fa-building"></i>
			<span class="menu-title">Edificios</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_salon" class="nav-link">
			<i class="fa-solid fa-building-columns"></i>
			<span class="menu-title">Salones</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_grupos" class="nav-link">
			<i class="fa-solid fa-users"></i>
			<span class="menu-title">Grupos</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_materia" class="nav-link">
			<i class="fa-solid fa-laptop-file"></i>
			<span class="menu-title">Materia</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_docentes" class="nav-link">
			<i class="fa-solid fa-chalkboard-user"></i>
			<span class="menu-title">Docentes</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_asistencia" class="nav-link">
			<i class="fa-regular fa-file-lines"></i>
			<span class="menu-title">Asistencia</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_incidencia" class="nav-link">
			<i class="fa-solid fa-school-circle-exclamation"></i>
			<span class="menu-title">Movimiento de Personal</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_comision" class="nav-link">
			<i class="fa-solid fa-file-invoice"></i>
			<span class="menu-title">Comisiones</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_inhabil" class="nav-link">
			<i class="fa-solid fa-calendar-day"></i>
			<span class="menu-title">Días Inhábiles</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_licencia" class="nav-link">
			<i class="fa-regular fa-address-card"></i>
			<span class="menu-title">Licencias</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="list-header">Departamento de Recursos Financieros</li>
	<li class="list-divider"></li>
	<li class="list-header">Departamento de Recursos Materiales y Servicios</li>
	<li class="nav-item">
		<a href="#" id="jsp_parque" class="nav-link">
			<i class="fa-solid fa-car"></i>
			<span class="menu-title">Parque Vehicular</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_combustible" class="nav-link">
			<i class="fa-solid fa-gas-pump"></i>
			<span class="menu-title">Combustible</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_chofer" class="nav-link">
			<i class="fa-solid fa-user-tie"></i>
			<span class="menu-title">Chofer</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_compactasion_comisiones" class="nav-link">
			<i class="fa-solid fa-folder-tree"></i>
			<span class="menu-title">Compactación de Comisiones</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="list-divider-sdd"></li>
	<li class="list-header">DIRECCIÓN DE PLANEACIÓN Y VINCULACIÓN</li>
	<li class="list-divider"></li>
	<li class="list-header">Subdirección de Planeación</li>
	<li class="list-divider"></li>
	<li class="list-header">Departamento de Planeación y Programación</li>
	<li class="list-divider"></li>
	<li class="list-header">Departamento de Estadística y Evaluación</li>
	<li class="list-divider"></li>
	<li class="list-header">Departamento de Control Escolar</li>
	<li class="list-divider"></li>
	<li class="list-header">Subdirección de Vinculación</li>
	<li class="list-divider"></li>
	<li class="list-header">Departamento de Vinculación</li>
	<li class="list-divider"></li>
	<li class="list-header">Departamento de Difusión y Concertación</li>
	<li class="list-divider"></li>
	<li class="list-header">Departamento de Residencias Profesionales y Servicio Social</li>
	<li class="list-divider-sdd"></li>
	<li class="list-header">DIRECCIÓN ACADÉMICA</li>
	<li class="list-divider"></li>
	<li class="list-header">Subdirección de Posgrado e Investigación</li>
	<li class="list-divider"></li>
	<li class="list-header">Departamento de Posgrado e Investigación</li>
	<li class="list-divider"></li>
	<li class="list-header">Subdirección Académica</li>
	<li class="list-divider"></li>
	<li class="list-header">Departamento de Desarrollo Académico</li>
	<li class="list-divider"></li>
	<li class="list-header">Departamento de Ciencias Básicas</li>
	<li class="list-divider"></li>
	<li class="list-header">División de Ingeniería Bioquímica</li>
	<li class="list-divider"></li>
	<li class="list-header">División de Ingeniería Electromecánica</li>
	<li class="list-divider"></li>
	<li class="list-header">División de Gastronomia</li>
	<li class="list-divider"></li>
	<li class="list-header">División de Ingeniería en Sistemas Computacionales</li>
	<li class="list-divider"></li>
	<li class="list-header">División de Ingeniería Industrial</li>
	<li class="list-divider"></li>
	<li class="list-header">División de Ingeniería Mecatrónica</li>
<?php } ?>
<?php if ($nivel_sesion == 3 && $estructura_real == 10100) { /*SSA*/ ?>
	<li class="list-header">INICIO</li>
	<li class="nav-item">
		<a href="index.php" id="jsp_inicio" class="nav-link active">
			<i class="fa-solid fa-house-chimney"></i>
			<span class="menu-title">Inicio</span>
		</a>
	</li>
	<li class="list-divider-sdd"></li>
	<li class="list-header">SUBDIRECCIÓN DE SERVICIOS ADMINISTRATIVOS</li>
	<li class="nav-item">
		<a href="#" id="jsp_dash_ssa" class="nav-link">
			<i class="fa-solid fa-chart-line"></i>
			<span class="menu-title">Dashboard</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_usuarios_ssa" class="nav-link">
			<i class="fa-regular fa-user"></i>
			<span class="menu-title">Usuarios</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_documentos" class="nav-link">
			<i class="fa-solid fa-file-lines"></i>
			<span class="menu-title">Documentos</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_historico_documentos" class="nav-link">
			<i class="fa-solid fa-clock-rotate-left"></i>
			<span class="menu-title">Historico Documentos</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_catalogo_comisiones" class="nav-link">
			<i class="fa-solid fa-route"></i>
			<span class="menu-title">Comisiones Realizadas</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="list-header">Departamento de Personal</li>
	<li class="nav-item">
		<a href="#" id="jsp_edificio" class="nav-link">
			<i class="fa-regular fa-building"></i>
			<span class="menu-title">Edificios</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_salon" class="nav-link">
			<i class="fa-solid fa-building-columns"></i>
			<span class="menu-title">Salones</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_grupos" class="nav-link">
			<i class="fa-solid fa-users"></i>
			<span class="menu-title">Grupos</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_materia" class="nav-link">
			<i class="fa-solid fa-laptop-file"></i>
			<span class="menu-title">Materia</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_docentes" class="nav-link">
			<i class="fa-solid fa-chalkboard-user"></i>
			<span class="menu-title">Docentes</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_asistencia" class="nav-link">
			<i class="fa-regular fa-file-lines"></i>
			<span class="menu-title">Asistencia</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_incidencia" class="nav-link">
			<i class="fa-solid fa-school-circle-exclamation"></i>
			<span class="menu-title">Movimiento de Personal</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_comision" class="nav-link">
			<i class="fa-solid fa-file-invoice"></i>
			<span class="menu-title">Comisiones</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_inhabil" class="nav-link">
			<i class="fa-solid fa-calendar-day"></i>
			<span class="menu-title">Días Inhábiles</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_licencia" class="nav-link">
			<i class="fa-regular fa-address-card"></i>
			<span class="menu-title">Licencias</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="list-header">Departamento de Recursos Financieros</li>
	<li class="nav-item">
		<a href="#" id="jsp_pagos" class="nav-link">
			<i class="fa-solid fa-money-check-dollar"></i>
			<span class="menu-title">Pagos</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="list-header">Departamento de Recursos Materiales y Servicios</li>
	<li class="nav-item">
		<a href="#" id="jsp_parque" class="nav-link">
			<i class="fa-solid fa-car"></i>
			<span class="menu-title">Parque Vehicular</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_combustible" class="nav-link">
			<i class="fa-solid fa-gas-pump"></i>
			<span class="menu-title">Combustible</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_chofer" class="nav-link">
			<i class="fa-solid fa-user-tie"></i>
			<span class="menu-title">Chofer</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_compactasion_comisiones" class="nav-link">
			<i class="fa-solid fa-folder-tree"></i>
			<span class="menu-title">Compactación de Comisiones</span>
		</a>
	</li>
	<li class="list-divider"></li>
<?php } ?>
<?php if ($nivel_sesion == 5 && $estructura_real == 10100 || $nivel_sesion == 7 && $estructura_real == 10100) { /*SSA Administrativos*/ ?>
	<li class="list-header">INICIO</li>
	<li class="nav-item">
		<a href="index.php" id="jsp_inicio" class="nav-link active">
			<i class="fa-solid fa-house-chimney"></i>
			<span class="menu-title">Inicio</span>
		</a>
	</li>
	<li class="list-divider-sdd"></li>
	<li class="list-header">SUBDIRECCIÓN DE SERVICIOS ADMINISTRATIVOS</li>
	<li class="nav-item">
		<a href="#" id="jsp_usuarios_ssa" class="nav-link">
			<i class="fa-regular fa-user"></i>
			<span class="menu-title">Usuarios</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_documentos" class="nav-link">
			<i class="fa-solid fa-file-lines"></i>
			<span class="menu-title">Documentos</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_historico_documentos" class="nav-link">
			<i class="fa-solid fa-clock-rotate-left"></i>
			<span class="menu-title">Historico Documentos</span>
		</a>
	</li>
<?php } ?>
<?php if ($nivel_sesion == 4 && $estructura_real == 10110 || $nivel_sesion == 5 && $estructura_real == 10110) {/*Jefe de departamento Personal & admon*/ ?>
	<li class="list-header">INICIO</li>
	<li class="nav-item">
		<a href="index.php" id="jsp_inicio" class="nav-link active">
			<i class="fa-solid fa-house-chimney"></i>
			<span class="menu-title">Inicio</span>
		</a>
	</li>
	<li class="list-divider-sdd"></li>
	<li class="list-header">Departamento de Personal</li>
	<li class="nav-item">
		<a href="#" id="jsp_documentos" class="nav-link">
			<i class="fa-solid fa-file-lines"></i>
			<span class="menu-title">Documentos</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_usuarios_ssa" class="nav-link">
			<i class="fa-regular fa-user"></i>
			<span class="menu-title">Usuarios</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_edificio" class="nav-link">
			<i class="fa-regular fa-building"></i>
			<span class="menu-title">Edificios</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_salon" class="nav-link">
			<i class="fa-solid fa-building-columns"></i>
			<span class="menu-title">Salones</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_grupos" class="nav-link">
			<i class="fa-solid fa-users"></i>
			<span class="menu-title">Grupos</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_materia" class="nav-link">
			<i class="fa-solid fa-laptop-file"></i>
			<span class="menu-title">Materia</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_docentes" class="nav-link">
			<i class="fa-solid fa-chalkboard-user"></i>
			<span class="menu-title">Docentes</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_asistencia" class="nav-link">
			<i class="fa-regular fa-file-lines"></i>
			<span class="menu-title">Asistencia</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_incidencia" class="nav-link">
			<i class="fa-solid fa-school-circle-exclamation"></i>
			<span class="menu-title">Movimiento de Personal</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_licencia" class="nav-link">
			<i class="fa-regular fa-address-card"></i>
			<span class="menu-title">Licencias</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_inhabil" class="nav-link">
			<i class="fa-solid fa-calendar-day"></i>
			<span class="menu-title">Días Inhábiles</span>
		</a>
	</li>
	<li class="list-divider"></li>
<?php } ?>
<?php if ($nivel_sesion == 4 && $estructura_real == 10130 || $nivel_sesion == 5 && $estructura_real == 10130) {/*Jefe de Recursos Materiales y Servicios y administradores*/ ?>
	<li class="list-header">INICIO</li>
	<li class="nav-item">
		<a href="index.php" id="jsp_inicio" class="nav-link active">
			<i class="fa-solid fa-house-chimney"></i>
			<span class="menu-title">Inicio</span>
		</a>
	</li>
	<li class="list-divider-sdd"></li>
	<li class="list-header">Departamento de Recursos Materiales y Servicios</li>
	<li class="nav-item">
		<a href="#" id="jsp_documentos" class="nav-link">
			<i class="fa-solid fa-file-lines"></i>
			<span class="menu-title">Documentos</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_parque" class="nav-link">
			<i class="fa-solid fa-car"></i>
			<span class="menu-title">Parque Vehicular</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_combustible" class="nav-link">
			<i class="fa-solid fa-gas-pump"></i>
			<span class="menu-title">Combustible</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_chofer" class="nav-link">
			<i class="fa-solid fa-user-tie"></i>
			<span class="menu-title">Chofer</span>
		</a>
	</li>
	<li class="list-divider"></li>
<?php } ?>
<?php if ($nivel_sesion == 4 && $estructura_real == 10120 || $nivel_sesion == 5 && $estructura_real == 10120 || $nivel_sesion == 7 && $estructura_real == 10120) {/*Jefe de Financieros y administrativos*/ ?>
	<li class="list-header">INICIO</li>
	<li class="nav-item">
		<a href="index.php" id="jsp_inicio" class="nav-link active">
			<i class="fa-solid fa-house-chimney"></i>
			<span class="menu-title">Inicio</span>
		</a>
	</li>
	<li class="list-divider-sdd"></li>
	<li class="list-header">Departamento de Recursos Financieros</li>
	<li class="nav-item">
		<a href="#" id="jsp_documentos" class="nav-link">
			<i class="fa-solid fa-file-lines"></i>
			<span class="menu-title">Documentos</span>
		</a>
	</li>
	<li class="list-divider"></li>
	<li class="nav-item">
		<a href="#" id="jsp_pagos" class="nav-link">
			<i class="fa-solid fa-money-check-dollar"></i>
			<span class="menu-title">Pagos</span>
		</a>
	</li>
<?php } ?>
<?php /*if ($nivel_sesion == 5 && $estructura_real == 10140 || $nivel_sesion == 7 && $estructura_real == 10140) {se modifico esta linea porque la mtra angelica es la unica que entrase manejara por su id*/ 
	if($id_software_sesion == '100117'){
?>
	<li class="list-header">INICIO</li>
	<li class="nav-item">
		<a href="index.php" id="jsp_inicio" class="nav-link active">
			<i class="fa-solid fa-house-chimney"></i>
			<span class="menu-title">Inicio</span>
		</a>
	</li>
	<li class="list-divider-sdd"></li>
	<li class="list-header">Departamento de Compras</li>
	<li class="nav-item">
		<a href="#" id="jsp_documentos" class="nav-link">
			<i class="fa-solid fa-file-lines"></i>
			<span class="menu-title">Documentos</span>
		</a>
	</li>
	<li class="nav-item">
		<a href="#" id="jsp_historico_documentos" class="nav-link">
			<i class="fa-solid fa-clock-rotate-left"></i>
			<span class="menu-title">Historico Documentos</span>
		</a>
	</li>
<?php } ?>