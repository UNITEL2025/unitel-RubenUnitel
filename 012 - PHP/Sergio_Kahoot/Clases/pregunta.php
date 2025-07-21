<?php

class Pregunta {
    public $id_pregunta;
    public $pregunta;
    public $respuestas;
    public $correcta;

    private $filename = "preguntas.txt";

    function __construct(
        $id_pregunta,
        string $pregunta,
        array $respuestas,
        int $correcta
    ) {
        
        $this->id_pregunta = $id_pregunta;
        $this->pregunta = $pregunta;
        $this->respuestas = $respuestas;
        $this->correcta = $correcta;
    }

    function save() {
        if ($this->id_pregunta === null) {
            $this->id_pregunta = $this->getLastId();
        }
        $myfile = fopen($this->filename, "a") or die("Unable to open file!");
        fwrite($myfile, $this->toJSON() . "\n");
        fclose($myfile);
    }

    function toJSON() {
        return json_encode($this);
    }

    function getLastId(): int {
        return count($this->getAllJSON());
    }

    function getAllJSON(): array {
        $salida = [];

        if (!file_exists($this->filename)) {
            return $salida;
        }

        $myfile = fopen($this->filename, "r") or die("Unable to open file!");

        while (($buffer = fgets($myfile)) !== false) {
            $obj = json_decode($buffer);
            if ($obj !== null) {
                // Creamos una instancia desde el JSON leído
                $item = new Pregunta(
                    $obj->id_pregunta,
                    $obj->pregunta,
                    (array)$obj->respuestas,
                    $obj->correcta
                );
                $salida[] = $item;
            }
        }

        fclose($myfile);
        return $salida;
    }
    function getById() : pregunta {
        
    }
}
