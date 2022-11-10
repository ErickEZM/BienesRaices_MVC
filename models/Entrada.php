<?php

namespace Model;

class Entrada extends ActiveRecord {
    protected static $tabla = 'entradas';
    protected static $columnasDB = ['id', 'titulo', 'fecha', 'autor', 'imagen', 'descripcion'];

    public $id;
    public $titulo;
    public $fecha;
    public $autor;
    public $imagen;
    public $descripcion;

    public function __construct($args = [])
    {
        $this-> id = $args['id'] ?? null;
        $this-> titulo = $args['titulo'] ?? '';
        $this-> fecha = date('d/m/Y');
        $this-> autor = $args['autor'] ?? '';
        $this-> imagen = $args['imagen'] ?? '';
        $this-> descripcion = $args['descripcion'] ?? '';
        
    }

    public function validar() {
        if(!$this->titulo) {
            self::$errores[] = 'Debes añadir un titulo';
        }

        if (!$this->autor) {
            self::$errores[] = 'El nombre del autor es obligatorio';
        }

        if (!$this->fecha) {
            self::$errores[] = 'La fecha es obligatoria';
        }

        if(!$this->imagen){
            self::$errores[] = 'La imagen es obligatoria';
        }

        if (strlen($this->descripcion) < 50) {
            self::$errores[] = 'La descripcion es obligatoria y debe tener al menos 50 caracteres';
        }




        return self::$errores;
    }
}