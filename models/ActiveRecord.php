<?php
    namespace Model;
    class ActiveRecord {
        // Base DE DATOS
        protected static $db;
        protected static $tabla = '';
        protected static $columnasDB = [];

        // Alertas y Mensajes
        protected static $alertas = [];
        
        // Definir la conexión a la BD - includes/database.php
        public static function setDB($database) {
            self::$db = $database;
        }

        public static function setAlerta($tipo, $mensaje) {
            static::$alertas[$tipo][] = $mensaje;
        }

        // Validación
        public static function getAlertas() {
            return static::$alertas;
        }

        public function validar() {
            static::$alertas = [];
            return static::$alertas;
        }

        // Consulta SQL para crear un objeto en Memoria
        public static function consultarSQL($query) {
            // Consultar la base de datos
            $resultado = self::$db->query($query);

            // Iterar los resultados
            $array = [];
            while($registro = $resultado->fetch_assoc()) {
                $array[] = static::crearObjeto($registro);
            }

            // liberar la memoria
            $resultado->free();

            // retornar los resultados
            return $array;
        }

        // Crea el objeto en memoria que es igual al de la BD
        protected static function crearObjeto($registro) {
            $objeto = new static;

            foreach($registro as $key => $value ) {
                if(property_exists( $objeto, $key  )) {
                    $objeto->$key = $value;
                }
            }

            return $objeto;
        }

        // Identificar y unir los atributos de la BD
        public function atributos() {
            $atributos = [];
            foreach(static::$columnasDB as $columna) {
                if($columna === 'id') continue;
                $atributos[$columna] = $this->$columna;
            }
            return $atributos;
        }

        // Sanitizar los datos antes de guardarlos en la BD
        public function sanitizarAtributos() {
            $atributos = $this->atributos();
            $sanitizado = [];
            foreach($atributos as $key => $value ) {
                $sanitizado[$key] = self::$db->escape_string($value);
            }
            return $sanitizado;
        }

        // Sincroniza BD con Objetos en memoria
        public function sincronizar($args=[]) { 
            foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
            }
        }

        // Registros - CRUD
        public function guardar($nombre_campo) {
            $resultado = '';

            if(!is_null($this -> $nombre_campo)) {
                // actualizar
                $resultado = $this->actualizar('id_servicio');
            } else {
                // Creando un nuevo registro
                $resultado = $this->crear();
            }
            return $resultado;
        }

        public function guardarUsuario() {
            $resultado = '';
            if(!is_null($this->id_usuario)) {
                // actualizar
                $resultado = $this->actualizar();
            } else {
                // Creando un nuevo registro
                $resultado = $this->crear();
            }
            return $resultado;
        }

        public function guardarCita() {
            $resultado = '';
            if(!is_null($this->id_cita)) {
                debuguear($this);
                // actualizar
                $resultado = $this->actualizar();
            } else {
                // Creando un nuevo registro
                $resultado = $this->crear();
            }
            return $resultado;
        }

        public function guardarCitaServicio() {
            $resultado = '';
            if(!is_null($this->id_citaServicio)) {
                debuguear($this);
                // actualizar
                $resultado = $this->actualizar();
            } else {
                // Creando un nuevo registro
                $resultado = $this->crear();
            }
            return $resultado;
        }

        public function guardarServicio() {
            $resultado = '';

            if(!is_null($this->id_servicio)) {
                debuguear($this);
                // actualizar
                $resultado = $this->actualizar();
            } else {
                // Creando un nuevo registro
                $resultado = $this->crear();
            }
            return $resultado;
        }

        // Todos los registros
        public static function all() {
            $query = "SELECT * FROM " . static::$tabla;
            $resultado = self::consultarSQL($query);
            return $resultado;
        }

        // Busca un registro por su id
        public static function find($id) {
            $query = "SELECT * FROM " . static::$tabla  ." WHERE id = ${id}";
            $resultado = self::consultarSQL($query);
            return array_shift( $resultado ) ;
        }

        // Busca un registro por su id_cita
        public static function BuscarCita($id_cita) {
            $query = "SELECT * FROM " . static::$tabla  ." WHERE id_cita = ${id_cita}";
            $resultado = self::consultarSQL($query);
            return array_shift( $resultado ) ;
        }

        // Busca un registro por su id
        public static function buscar($id_campo, $nombre_campo) {
            $query = "SELECT * FROM " . static::$tabla  ." WHERE ${nombre_campo} = ${id_campo}";
            $resultado = self::consultarSQL($query);
            return array_shift( $resultado ) ;
        }

        // Consulta Plana de SQL 
        public static function SQL($query) {
            $resultado = self::consultarSQL($query);
            return $resultado;
        }

        // Busca un registro por su usuario
        public static function findUsuario($nombre_usuario) {
            $query = "SELECT * FROM " . static::$tabla  ." WHERE user_usuario = '${nombre_usuario}'";
            $resultado = self::consultarSQL($query);
            return array_shift( $resultado ) ;
        }

        // Obtener Registros con cierta cantidad
        public static function get($limite) {
            $query = "SELECT * FROM " . static::$tabla . " LIMIT ${limite}";
            $resultado = self::consultarSQL($query);
            return array_shift( $resultado ) ;
        }

        // crea un nuevo registro
        public function crear() {
            // Sanitizar los datos
            $atributos = $this->sanitizarAtributos();

            // Insertar en la base de datos
            $query = " INSERT INTO " . static::$tabla . " ( ";
            $query .= join(', ', array_keys($atributos));
            $query .= " ) VALUES (' "; 
            $query .= join("', '", array_values($atributos));
            $query .= " ') ";

            // Resultado de la consulta
            $resultado = self::$db->query($query);
            return [
                'resultado' =>  $resultado,
                'id' => self::$db->insert_id
            ];
        }

        // Actualizar el registro
        public function actualizar($nombre_campo) {
            // Sanitizar los datos
            $atributos = $this->sanitizarAtributos();

            // Iterar para ir agregando cada campo de la BD
            $valores = [];
            foreach($atributos as $key => $value) {
                $valores[] = "{$key}='{$value}'";
            }

            // Consulta SQL
            $query = "UPDATE " . static::$tabla ." SET ";
            $query .=  join(', ', $valores );
            $query .= " WHERE ${nombre_campo} = '" . self::$db->escape_string($this->$nombre_campo) . "' ";
            $query .= " LIMIT 1 "; 

            // Actualizar BD
            $resultado = self::$db->query($query);
            return $resultado;
        }

        // Eliminar un Registro por su ID
        public function eliminarCita() {
            $query = "DELETE FROM "  . static::$tabla . " WHERE id_cita = " . self::$db->escape_string($this->id_cita) . " LIMIT 1";
            $resultado = self::$db->query($query);
            return $resultado;
        }

        public function eliminar($nombre_campo) {
            $query = "DELETE FROM "  . static::$tabla . " WHERE ${nombre_campo} = " . self::$db->escape_string($this->$nombre_campo) . " LIMIT 1";
            $resultado = self::$db->query($query);
            return $resultado;
        }
    }