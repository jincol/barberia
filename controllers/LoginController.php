<?php

namespace Controllers;

use Clases\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{

    public static function login(Router $router)
    {
        $alertas = Usuario::getAlertas();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $aut = new Usuario($_POST);

            $alertas = $aut->validarlogin();

            if (empty($alertas)) {

                //CREAMOS UN USUARIO
                $usuario = Usuario::where("email", $aut->email);

                if ($usuario) {

                    $autenticado = $usuario->comprobarPasswordAndConfirmado($aut->password);


                    if ($autenticado) {
                        session_start();
                        var_dump('Session started'); // Depuración
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;


                        // REDIRRECIONAR POR ROL
                        if ($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }
                    }
                } else {
                    Usuario::setAlerta("error", "El usuario no existe");
                    var_dump(Usuario::getAlertas()); // Depuración

                }
            }
        }

        $alertas = usuario::getAlertas();

        $router->render("auth/login", [
            "alertas" => $alertas
        ]);
    }

    public static function logout(Router $router)
    {
        session_start();

        session_destroy();
        header('Location: /');
    }
    public static function olvide(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Usuario($_POST);

            $alertas = $auth->validaremail();

            if (empty($alertas)) {
                $usuario = Usuario::where("email", $auth->email);

                if ($usuario && $usuario->confirmado === '1') {

                    $usuario->generarToken();
                    $usuario->guardar();

                    //ENVIAMOS EMAIL CON INSTRUCCIONES
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();



                    usuario::setAlerta("exito", "Revisa tu Email");
                } else {
                    Usuario::setAlerta("error", "El usuario no existe o no esta confirmado");
                    $alertas = usuario::getAlertas();
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/olvide", [
            "alertas" => $alertas
        ]);
    }
    public static function recuperar(Router $router)
    {

        $alertas = [];
        $error = false;

        $token = s($_GET['token']);

        //BUSCAR USUARIO POR TOKEN
        $usuario = usuario::where("token", $token);

        if (empty($usuario)) {
            Usuario::setAlerta("error", "TOKEN NO VALIDO");
            $error = true;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $password = new Usuario($_POST);

            $alertas = $password->validarpassword();


            if (empty($alertas)) {
                /*  
            $password->hashPassword();

            $usuario->password = $password->password;

            $usuario->token = null

            $usuario->guardar

            */
                $usuario->password = null;

                $usuario->password = $password->password;

                $usuario->hashPassword();

                $usuario->token = null;

                $resultado = $usuario->guardar();

                if (!$resultado) {
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/recuperar-password", [
            "alertas" => $alertas,
            "error" => $error
        ]);
    }

    public static function crear(Router $router)
    {

        $usuario = new Usuario;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);
            
            $alertas = $usuario->ValidarNuevaCuenta();

            //REVISAR SI ERRORES ESTA VACIO
            if (empty($alertas)) {

                $resultado =  $usuario->existeUsuario();

                if ($resultado->num_rows) {
                    $alertas = usuario::getAlertas();
                } else {
                    //HASH PASSWORD
                    $password = $usuario->hashPassword();

                    $token = $usuario->generarToken();
                    
                    //ENVIAMOS EL EMAIL
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                    //ENVIAMOS LA CONFIRMACION POR EMAIL
                    $email->enviarConfirmacion();

                    //GUARDAMOS
                    $resultado = $usuario->guardar();
                   
                    
                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }


        $router->render("auth/crear-cuenta", [
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
    }


    public static function mensaje(Router $router)
    {
        $router->render("/auth/mensaje", []);
    }

    public static function confirmar(Router $router)
    {

        $alertas = [];

        $token = s($_GET['token']);
        //CONSUTA POR TOKEN
        $usuario = usuario::where("token", $token);

        if (empty($usuario)) {
            // MOSTRAR ERROR
            usuario::setAlerta("error", "Token no Valido");
        } else {
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();

            Usuario::setAlerta("exito", "Usuario confirmado con exito");
        }

        $alertas = usuario::getAlertas();

        $router->render("/auth/confirmar-cuenta", [
            "alertas" => $alertas,
        ]);
    }
}
