<?php

namespace Controllers;

use Model\Servicios;
use Model\Cita;
use Model\CitaServicio;

class ApiController
{

    public static function index()
    {
        $servicios = Servicios::all();

        echo json_encode($servicios);
    }

    public static function guardar()
    {
        $cita = new Cita($_POST);
        
        // ALMACENA LA CITA Y RETORNA EL ID DE CITA
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        // ALMACENA EL ID->CITA Y  EL ID->SERVICIOS
        $idServicios = explode(',',$_POST['servicios']); //Crea un array separado pro ","

        foreach ($idServicios as $idServicio) {
            $args = [
                'citasId' => $id,
                'serviciosId' => $idServicio
            ];

            $citaServicio = new CitaServicio($args);

            $citaServicio->guardar();
        }


        echo json_encode(["resultado" => $resultado]); //convierte en JSON
    }

    public static function eliminar()
    {   
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = filter_var( $_POST['id'],FILTER_VALIDATE_INT);
            $cita = Cita::find($id);
            $resultado = $cita->eliminar();

            if($resultado){
                header('Location: '.$_SERVER['HTTP_REFERER']);
            }
        }
         
         
    }
}
