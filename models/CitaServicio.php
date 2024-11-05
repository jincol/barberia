<?php

namespace Model;

class CitaServicio extends ActiveRecord {

    protected static $tabla = 'citasservicios';
    protected static $columnaDB = ['id','citaId','servicioId'];

    public $id;
    public $citasId;
    public $serviciosId;

    public function __construct($args = []){

        $this->id = $args['id'] ?? null;
        $this->citasId = $args['citaId'] ?? '';
        $this->serviciosId = $args['servicioId'] ?? '';

    }
}