<?php
    namespace Controllers;

    use Model\Servicio;

    use MVC\Router;
    
    class ServicioController {
        public static function index(Router $router) {
            if(!$_SESSION['nombre_usuario']) {
                session_start();
            }

            isAdmin();

            $servicios = Servicio :: all();

            $router -> render('servicios/index', [
                'nombre' => $_SESSION['nombre_usuario'],
                'servicios' => $servicios
            ]);

        }

        public static function crear(Router $router) {
            if(!$_SESSION['nombre_usuario']) {
                session_start();
            }

            isAdmin();

            $servicio = new Servicio();
            $alertas = [];

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $servicio -> sincronizar($_POST);
                $alertas = $servicio -> validar();

                if(empty($alertas)) {
                    $servicio -> guardarServicio();
                    header('Location: /servicios');
                }
            }


            $router -> render('servicios/crear', [
                'nombre' => $_SESSION['nombre_usuario'],
                'servicio' => $servicio,
                'alertas' => $alertas
            ]);

        }
        
        public static function actualizar(Router $router) {
            if(!$_SESSION['nombre_usuario']) {
                session_start();
            }

            isAdmin();

            if(!is_numeric($_GET['id'])) {
                header('Location: /servicios');
            }

            $servicio = Servicio :: buscar($_GET['id'], 'id_servicio');

            if(!$servicio) {
                header('Location: /servicios');
            }
            
            
            $alertas = [];

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $servicio -> sincronizar($_POST);
                $alertas = $servicio -> validar();

                if(empty($alertas)) {
                    $servicio -> guardar('id_servicio');

                    header('Location: /servicios');
                } 
            }

            $router -> render('servicios/actualizar', [
                'nombre' => $_SESSION['nombre_usuario'],
                'servicio' => $servicio,
                'alertas' => $alertas
            ]);

        }
        
        public static function eliminar() {
            if(!$_SESSION['nombre_usuario']) {
                session_start();
            }
            
            isAdmin();

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id_servicio = $_POST['id_servicio'];
                $servicio = Servicio :: buscar($id_servicio, 'id_servicio');
                $servicio -> eliminar('id_servicio');
                header('Location: /servicios');
            }   
        }
    }