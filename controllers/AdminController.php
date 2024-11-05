<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController
{
    //CONSULTA SQL CON VARIAS TABLAS Y JOIN
    public static function index(Router $router)
    {
        isAdmin();

        //VALIDAR FECHA GET
        $fecha = $_GET['fecha'] ?? date("Y-m-d");
        $fechaGet = explode("-", $fecha);
        $fechaGet = checkdate($fechaGet[1], $fechaGet[2], $fechaGet[0]);

        if (!$fechaGet) {
            header('Location: /404');
        }


        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.servicioId ";
        $consulta .= " WHERE fecha =  '$fecha' ";

        $cita = AdminCita::SQL($consulta);


        $router->render('/admin/index', [
            "nombre" => $_SESSION['nombre'],
            "citas" => $cita,
            "fecha" => $fecha
        ]);
    }

    
}
