$(document).ready(function(){
    $('.nav-offcanvas .navbar-nav .nav-item .nav-link').on('click', function(){
		$('.nav-offcanvas .navbar-nav .nav-item .nav-link.active').removeClass('active');
		$(this).addClass('active');
	});
    $('#jsp_home').click(function(){
        $('html, body').animate({scrollTop:0 }, 'slow');
    });
    $('#jsp_dash_dg').click(function(){
        $('#contenido_pagina').load('modulos/dash_dg.php');
        $('html, body').animate({ scrollTop:0}, 'slow');
        $('#aside_menu_cp').offcanvas('toggle');
    });
    $('#jsp_usuarios_ssa').click(function(){
        $('#contenido_pagina').load('modulos/usuarios.php');
        $('html, body').animate({ scrollTop:0}, 'slow');
        $('#aside_menu_cp').offcanvas('toggle');
    });
    $('#jsp_dash_ssa').click(function(){
        $('#contenido_pagina').load('modulos/dash_ssa.php');
        $('html, body').animate({ scrollTop:0}, 'slow');
        $('#aside_menu_cp').offcanvas('toggle');
    });
    $('#jsp_documentos').click(function(){
        $('#contenido_pagina').load('modulos/documentos.php');
        $('html, body').animate({scrollTop:0}, 'slow');
        $('#aside_menu_cp').offcanvas('toggle');
    });
    $('#jsp_edificio').click(function(){
        $('#contenido_pagina').load('modulos/edificios.php');
        $('html, body').animate({scrollTop:0}, 'slow');
        $('#aside_menu_cp').offcanvas('toggle');
    });
    $('#jsp_salon').click(function(){
        $('#contenido_pagina').load('modulos/salon.php');
        $('html, body').animate({scrollTop: 0}, 'slow');
        $('#aside_menu_cp').offcanvas('toggle');
    });
    $('#jsp_grupos').click(function(){
        $('#contenido_pagina').load('modulos/grupos.php');
        $('html, body').animate({scrollTop: 0}, 'slow');
        $('#aside_menu_cp').offcanvas('toggle');
    });
    $('#jsp_materia').click(function(){
        $('#contenido_pagina').load('modulos/materia.php');
        $('html, body').animate({scriollTop: 0}, 'slow');
        $('#aside_menu_cp').offcanvas('toggle');
    });
    $('#jsp_docentes').click(function(){
        $('#contenido_pagina').load('modulos/docentes.php');
        $('html, body').animate({scriollTop: 0}, 'slow');
        $('#aside_menu_cp').offcanvas('toggle');
    });
});