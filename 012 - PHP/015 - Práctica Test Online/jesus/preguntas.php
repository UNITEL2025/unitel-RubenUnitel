<?php

class pregunta {

    //Declaramos los atributos que va a tener una pregunta
    public $id;
    public $pregunta;
    public $respuestas; //Esto es un array con 4 opciones
    public $correcta; //Indica la respuesta correcta (0 a 3 -- 4 opciones)

    private static $filename = "preguntas.txt";

    //Constructor de la clase
    public function __construct(

        $id = null, 
        string $pregunta = "", 
        array $respuestas = [], 
        int $correcta = 1

        ) {

        $this->id = $id;
        $this->pregunta = $pregunta;
        $this->respuestas = $respuestas;
        $this->correcta = $correcta;

    }

    //Convierte el objeto en JSON
    public function toJSON() : string {
        return json_decode($this);
    }

    public function save() {

        if ($this->id === null) {

            $this->d = seft::getNextId();

        }

        $items = files::read(self::$filename);

    }

}