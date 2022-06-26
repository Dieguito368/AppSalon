<?php 
    namespace Model;

    class Servicio extends ActiveRecord {
        //Base de datos
        protected static $tabla = 'servicios';
        protected static $columnasDB = ['id_servicio', 'nombre_servicio', 'precio_servicio'];

        public $id_servicio;
        public $nombre_servicio;
        public $precio_servicio;

        public function __construct($args = []) {
            $this -> id_servicio = $args['id_servicio'] ?? null;
            $this -> nombre_servicio = $args['nombre_servicio'] ?? '';
            $this -> precio_servicio = $args['precio_servicio'] ?? '';
        }

        public function validar() {
            if(!$this -> nombre_servicio) {
                self :: $alertas['error'][] = 'El nombre del servicio es obligatorio';
            }

            if(!$this -> precio_servicio) {
                self :: $alertas['error'][] = 'El precio del servicio es obligatorio';
            }

            return self :: $alertas;
        } 
    }