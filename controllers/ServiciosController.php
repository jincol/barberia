    <?php

    namespace Controllers;

    use Model\Servicios;
    use MVC\Router;

    class ServiciosController
    {
        public static function index(Router $router)
        {
            isAdmin();

            $servicios = Servicios::all();
            // $alertas = Servicios::getAlertas();       


            $router->render('/servicios/index', [
                "nombre" => $_SESSION['nombre'],
                "servicios" => $servicios,
                // "alertas" => $alertas
            ]);
        }

        public static function crear(Router $router)
        {
            isAdmin();

            $servicios = new Servicios;
            $alertas = Servicios::getAlertas();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $servicios = new Servicios($_POST);

                $alertas = $servicios->validar();

                if (empty($alertas)) {
                    $resultado = $servicios->guardar();

                    if ($resultado) {
                        $servicios->setAlerta("exito", "El Servicio Fue añadido correctamente");
                        header('Location: /servicios');
                    }
                }
            }

            $router->render('/servicios/crear', [
                "nombre" => $_SESSION['nombre'],
                "alertas" => $alertas,
                "servicios" => $servicios
            ]);
        }

        public static function actualizar(Router $router)
        {
            isAdmin();

            // $id = filter_var(intval($_GET['id']), FILTER_VALIDATE_INT);

            if (!is_numeric($_GET['id'])) {
                return;
            }

            $servicios = Servicios::find($_GET['id']);
            if (!$servicios) header('Location: /404');
            $alertas = [];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $servicios->sincronizar($_POST);

                $alertas = $servicios->validar();

                if (empty($alertas)) {
                    $servicios->guardar();
                }
            }

            $router->render('/servicios/actualizar', [
                "nombre" => $_SESSION['nombre'],
                "servicios" => $servicios,
                "alertas" => $alertas
            ]);
        }
        public static function eliminar(Router $router)
        {
            isAdmin();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

                $servicios = Servicios::find($id);

                $servicios->eliminar();

                header('Location: /servicios');
            }
        }
    }
