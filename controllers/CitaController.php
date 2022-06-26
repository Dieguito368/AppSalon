<?php 
    namespace Controllers; 

    use MVC\Router;

    class CitaController {
        public static function index( Router $router ) {
            if(!$_SESSION['nombre_usuario']) {
                session_start();
            }

            isAuth();

            $router -> render('cita/index', [
                'nombre' => $_SESSION['nombre_usuario'],
                'id' => $_SESSION['id_usuario']
            ]);
        }
    }