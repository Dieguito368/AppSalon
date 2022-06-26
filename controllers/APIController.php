<?php 
    namespace Controllers;

    use Model\Servicio;
    use Model\Cita;
    use Model\CitaServicio;

    class APIController {
        public static function index() {
            $servicios = Servicio :: all();
            echo json_encode($servicios);
        }
        
        public static function guardar() {
            //Almacena la Cita y devuelve el ID
            $cita = new Cita($_POST);
            $resultado = $cita -> guardarCita();

            $idCita = $resultado['id'];

            //Almacena los servicios con el id de la cita
            $idServicios = explode(",", $_POST['servicios']);

            foreach ($idServicios as $idServicio) {
                $args = [
                    'citaID' => $idCita,
                    'servicioID' => $idServicio
                ];

                $citaServicio = new CitaServicio($args);
                $citaServicio -> guardarCitaServicio();
            }

            echo json_encode(['resultado' => $resultado]);
        }

        public static function eliminar() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id_cita = $_POST['id_cita'];

                $cita = Cita :: buscarCita($id_cita);
                $cita -> eliminarCita();

                header('Location: ' . $_SERVER['HTTP_REFERER']);
                debuguear($cita);
            }
        }
    }