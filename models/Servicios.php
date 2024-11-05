<?php

namespace Model;

class Servicios extends ActiveRecord
{
    protected static $tabla = "servicios";
    protected static $columnaDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? "";
        $this->precio = $args['precio'] ?? "";
    }

    public function validar()
    {

        if (!$this->nombre) {
            self::$alertas['error'][] = "Debe ingresar un nombre";
        }

        if (!$this->precio) {
            self::$alertas['error'][] = "El precio es obligatorio";
        } else if (!is_numeric($this->precio)) {
            self::$alertas['error'][] = "Formato de precio Invalido -> Ejem : 120 ó 15";
        }


        return self::$alertas;
    }
}
