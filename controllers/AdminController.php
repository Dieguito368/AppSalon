<?php
    namespace Controllers;
    
    use Model\AdminCita;

    use MVC\Router;
    
    class AdminController {
        public static function index( Router $router ) {
            if(!$_SESSION['nombre_usuario']) {
                session_start();
            }

            isAdmin();

            $fecha = $_GET['fecha'] ?? date('Y-m-d');
            $datosFecha = explode('-', $fecha);

            if(!checkdate($datosFecha[1], $datosFecha[2], $datosFecha[0])) {
                header('Location: /admin');
            }

            //Consultar la Base de Datos
            $consulta = "SELECT citas.id_cita, 
                                citas.hora_cita, 
                                CONCAT(usuarios.nombre_usuario, ' ', usuarios.apellidoPaterno_usuario) as cliente,
                                usuarios.user_usuario as user_cliente,
                                usuarios.telefono_usuario as telefono_cliente,
                                servicios.nombre_servicio,
                                servicios.precio_servicio
                        FROM citas 
                        LEFT OUTER JOIN usuarios ON citas.usuarioID = usuarios.id_usuario 
                        LEFT OUTER JOIN citasservicios ON citasservicios.citaID = citas.id_cita
                        LEFT OUTER JOIN servicios ON servicios.id_servicio = citasservicios.servicioID
                        WHERE admin = '0' and fecha_cita = '${fecha}'";

            $citas = AdminCita :: SQL($consulta);
            
            $router -> render('admin/index', [
                'nombre' => $_SESSION['nombre_usuario'],
                'citas'=> $citas, 
                'fecha' => $fecha,
            ]); 
        }
    }