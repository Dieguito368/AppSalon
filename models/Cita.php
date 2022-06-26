<?php 
    namespace Model;

    class Cita extends ActiveRecord {
        //Base de Datos
        protected static $tabla = 'citas';
        protected static $columnasDB = ['id_cita', 'fecha_cita', 'hora_cita', 'usuarioID'];

        public $id_cita;
        public $fecha_cita;
        public $hora_cita;
        public $usuarioID;

        public function __construct($args = []) {
            $this -> id_cita = $args['id_cita'] ?? null;
            $this -> fecha_cita = $args['fecha_cita'] ?? '';
            $this -> hora_cita = $args['hora_cita'] ?? '';
            $this -> usuarioID = $args['usuarioID'] ?? '';
        }
    }