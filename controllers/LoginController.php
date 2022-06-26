<?php
    namespace Controllers;

    use Model\Usuario;
    use MVC\Router;

    class LoginController {
        public static function login( Router $router ) {
            $alertas = [];

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $auth = new Usuario($_POST);
                $alertas = $auth -> validarLogin();

                //Revisar que alertas este vacio
                if(empty($alertas)) {
                    //Verificar que el usuario exista
                    $resultado = $auth -> findUsuario($auth -> user_usuario);

                    if($resultado) {
                        if($resultado -> comprobarPassword($auth -> password_usuario)) {
                            if(!isset($_SESSION)) {
                                session_start();
                            }

                            $_SESSION['id_usuario'] = $resultado -> id_usuario;
                            $_SESSION['nombre_usuario'] = $resultado -> nombre_usuario . " ". $resultado -> apellidoPaterno_usuario;
                            $_SESSION['user_usuario'] = $resultado -> user_usuario;
                            $_SESSION['login'] = true;
                            
                            // Redireccionamiento
                            if($resultado -> admin === "1") {
                                $_SESSION['admin'] = $resultado -> admin ?? null;

                                header('Location: /admin');
                            } else {
                                header('Location: /cita');
                            }

                        }
                    } else {
                        Usuario :: setAlerta('error', "El usuario '". $auth -> user_usuario ."' no está registrado");
                    }
                }
            }

            $alertas = Usuario :: getAlertas();     

            $router -> render('auth/login', [
                'alertas' => $alertas
            ]);
        }
        
        public static function logout() {
            session_start();

            $_SESSION = [];

            header('Location: /');   
        }
        
        public static function crear(Router $router) {
            $usuario = new Usuario($_POST);

            //Alertas vacias
            $alertas = [];
            
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $usuario -> sincronizar($_POST);
                $alertas = $usuario -> validarNuevaCuenta();

                //Revisar que alertas este vacio
                if(empty($alertas)) {
                    //Verificar que el usuario no este registrado
                    $resultado = $usuario -> existeUsuario();

                    if($resultado -> num_rows) {
                        $alertas = Usuario :: getAlertas();
                    } else {
                        //Hashear el Password
                        $usuario -> hashPassword(); 

                        //Crear el usuario
                        $resultado = $usuario -> guardarUsuario();

                        if($resultado) {
                            Usuario ::  setAlerta('exito', 'Usuario creado correctamente');
                        }
                    }
                }
            }
            
            $alertas = Usuario :: getAlertas();
            
            $router -> render('auth/crear-cuenta', [
                'usuario' => $usuario,
                'alertas' => $alertas
            ]);
            
        }
    }
?>