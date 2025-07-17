<?php

class Pregunta {
    // Propiedad
    public $id_pregunta; // Auto Incrementado
    public $pregunta;
    public $respuestas;
    public $correcta;

    // Propiedad genérica
    private $filename = "preguntas.txt";

    // Constructor
    function __construct(
        $id_pregunta, // INT o NULL
        string $pregunta,
        array $respuestas,
        int $correcta
    ) {
        if ($id_pregunta == null) {
            $this->id_pregunta = $this->getlastId();
        } else {
            $this->id_pregunta = $id_pregunta;
        }
        $this->pregunta = $pregunta;
        $this->respuestas = $respuestas;
        $this->correcta = $correcta;
    }

    // Guardar una pregunta (permanentemente)
    function save() {
        // Abrir el archivo
        $myfile = fopen($this->filename, "a") or die("Unable to open file!");
        // Escribir
        fwrite($myfile, $this->toJSON() ."\n");
        // Cerrar archivo
        fclose($myfile);
    }
    
    // Transforma el objeto en un JSON
    function toJSON() : string {
        return json_encode($this);
    }

    function getlastId() : int {
        // Obtenemos el numero total de preguntas
        $total = count($this->getAll());
        var_dump($total);
        die();
    }

    // TO DO Obtener todas las preguntas
    function getAll() : array {
        // Variable de la salida donde meteremos los objetos pregunta
        $salida = array();
        // Abrir el archivo con permisos de lectura línea por línea
        $myfile = fopen($this->filename, "r") or die("Unable to open file!");
        $lineas = array(); // Array de str codificado en JSON
        if ($myfile) {
            while (($buffer = fgets($myfile, filesize($this->filename))) !== false) {
                $lineas[] = $buffer;
            }
            if (!feof($myfile)) {
                echo "Error: fgets() falló\n";
            }
            fclose($myfile);
        }
        // Descodificar de JSON a objeto
        foreach ($lineas as $key => $value) {
            $obj = json_decode($value);
            // Instanciar una pregunta desde el objeto estándar
            $item = new Pregunta (
                $obj->id_pregunta,
                $obj->pregunta,
                (array) $obj->respuestas,
                $obj->correcta
            );
            $salida[] = $item;
        }
        // Añadimos el array salida
        return $salida;
    }
        // Instanciar cada pregunta
        // Guardar todas en un array
        // Devolver el array de preguntas

    // TO DO Obtener una sola pregunta por ID
    // TO DO Actualizar una pregunta
    // TO DO Eliminar

/*  $pregunta = array(
        "id_pregunta" => 0,
        "pregunta" => "",
        "respuestas" => array(
            0 => "",
            1 => "",
            2 => "",
            3 => ""),
        "correcta" => 1
    );*/
}