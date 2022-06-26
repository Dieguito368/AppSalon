<?php
    namespace Model;

    class Usuario extends ActiveRecord {
        //Base de datos
        protected static $tabla = 'usuarios';
        protected static $columnasDB = ['id_usuario', 'nombre_usuario', 'apellidoPaterno_usuario', 'user_usuario', 'password_usuario', 'telefono_usuario', 'admin'];
        
        public $id_usuario;
        public $nombre_usuario;
        public $apellidoPaterno_usuario;
        public $telefono_usuario;
        public $user_usuario;
        public $password_usuario;
        public $admin;

        public function __construct($args = []) {
            $this -> id_usuario = $args['id'] ?? null;
            $this -> nombre_usuario = $args['nombre'] ?? '';
            $this -> apellidoPaterno_usuario = $args['apellidoPaterno'] ?? '';
            $this -> telefono_usuario = $args['telefono'] ?? '';
            $this -> user_usuario = $args['usuario'] ?? '';
            $this -> password_usuario = $args['password'] ?? '';
            $this -> admin = $args['admin'] ?? '0';
        }

        //Mensajes de validación para la creación de una cuenta
        public function validarNuevaCuenta() {
            if(!$this -> nombre_usuario) {
                self :: $alertas['error'][] = 'El nombre es obligatorio';
            }

            if(!$this -> apellidoPaterno_usuario) {
                self :: $alertas['error'][] = 'El apellido es obligatorio';
            }

            if(!$this -> telefono_usuario) {
                self :: $alertas['error'][] = 'El telefono es obligatorio';
            }

            if(!$this -> user_usuario) {
                self :: $alertas['error'][] = 'El usuario es obligatorio';
            }

            if(strlen(!$this -> password_usuario)) {
                self :: $alertas['error'][] = 'El password es obligatorio';
            } else if(strlen($this -> password_usuario) < 6) {
                self :: $alertas['error'][] = 'El password debe contener al menos 6 caracteres';
            }

            return self :: $alertas;
        }

        //Revisa si el usuario ya existe
        public function existeUsuario() {
            $query = "SELECT * FROM " . self :: $tabla . " WHERE user_usuario = '" . $this -> user_usuario . "' LIMIT 1";
            $resultado = self :: $db -> query($query);

            if($resultado -> num_rows) {
                self :: $alertas['error'][] ="El usuario '" . $this -> user_usuario . "' ya esta registrado";
            }

            return $resultado;
        }

        public function hashPassword() {
            $this -> password_usuario = password_hash($this -> password_usuario, PASSWORD_BCRYPT);
        }

        //Mensajes de validación para la autenticación
        public function validarLogin() {
            if(!$this -> user_usuario) {
                self :: $alertas['error'][] = 'El usuario es obligatorio';
            }

            if(!$this -> password_usuario) {
                self :: $alertas['error'][] = 'El password es obligatorio';
            }
            
            return self :: $alertas;
        }
        
        public function comprobarPassword($password) {
            $resultado = password_verify($password, $this -> password_usuario);

            if($resultado) {
                return true;
            } else {
                self :: $alertas['error'][] = 'El password es incorrecto';
            }
        }
    }
