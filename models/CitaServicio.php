<?php 
    namespace Model;

    class CitaServicio extends ActiveRecord {
        //Base de Datos
        protected static $tabla = 'citasServicios';
        protected static $columnasDB = ['id_citaServicio', 'citaID', 'servicioID'];

        public $id_citaServicio;
        public $citaID;
        public $servicioID;

        public function __construct($args = []) {
            $this -> id_citaServicio = $args['id_citaServicio'] ?? null;
            $this -> citaID = $args['citaID'] ?? '';
            $this -> servicioID = $args['servicioID'] ?? '';
        }
    }