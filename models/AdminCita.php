<?php 
    namespace Model;

    class AdminCita extends ActiveRecord {
        //Base de Datos
        protected static $tabla = 'citasServicios';
        protected static $columnasDB = ['id_cita', 'hora_cita', 'cliente', 'user_cliente', 'telefono_cliente', 'nombre_servicio', 'precio_servicio'];

        public $id_cita;
        public $hora_cita;
        public $cliente;
        public $user_cliente;
        public $telefono_cliente;
        public $nombre_servicio;
        public $precio_servicio;

        public function __construct($args = []) {
            $this -> id_cita = $args['id_cita'] ?? null;
            $this -> hora_cita = $args['hora_cita'] ?? '';
            $this -> cliente = $args['cliente'] ?? '';
            $this -> user_cliente = $args['user_ciente'] ?? '';
            $this -> telefono_cliente = $args['telefono_cliente'] ?? '';
            $this -> nombre_servicio = $args['nombre_servicio'] ?? '';
            $this -> precio_servicio = $args['precio_servicio'] ?? '';
        }
    }