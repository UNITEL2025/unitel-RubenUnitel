<?php

class pregunta {
    //Propiedad
    public $id_pregunta; //Auto Incrementado
    public $pregunta;
    public $respuestas;
    public $correcta;

    //Propiedad genérica
    private $filename = "preguntas.txt";

    //Constructor
    function __construct (
        $id_pregunta, //Int o null
        string $pregunta,
        array $respuestas,
        int $correcta
    ) {
        if ($this->id_pregunta == null)
        {
            $this->id_pregunta = $this->getLastId();
        }
        else
        {
            $this->id_pregunta = $id_pregunta;
        }
        $this->pregunta = $pregunta;
        $this->respuestas = $respuestas;
        $this->correcta = $correcta;
    }

    //Guardar una pregunta (permanentemente)
    function save() {
        //1. Abrir el archivo
        $myfile = fopen($this->filename, "a") or die("Unable to open file!");
        //2.Escribir
        fwrite($myfile, $this->toJSON()."\n");
        //3. Cerrar archivo
        fclose($myfile);
    }

    //Transforma el objeto en UN JSON
    function toJSON() : string {
        return json_encode($this);
    }

    function getLastId() : int {
        //Obtenemos el número total de preguntas
        return count($this->getAllJSON());
    }

    //Obtener todas las preguntas en formato JSON
    function getAllJSON() : array {
        //Variable de salida donde meteremos los objetos pregunta
        $salida = array();

        //Comprobamos si el archivo existe
        //Si existe -> Seguimos
        //Si NO existe -> Devolvemos array vacío
        if (!file_exists($this->filename))
        {
            return $salida;
        }
        //1. Abrir el archivo con permisos de lectura línea por línea
        $myfile = fopen($this->filename, "r") or die("Unable to open file!");
        $lineas = array(); //Array de str codificado en JSON
        if ($myfile) {
            while (($buffer = fgets($myfile, filesize($this->filename))) !== false) {
                $lineas[] = $buffer;
            }
            if (!feof($myfile)) {
                echo "Error: fgets() falló\n";
            }
            fclose($myfile);
        }
        //2. Descodificar de JSON a Objeto
        foreach ($lineas as $key => $value) {
            if (json_decode($value) != null)
            {
                $salida[] = json_decode($value);
            }
        }
        //3. Devolver el array de preguntas
        return $salida;
    }
    //Instanciar una pregunta desde el objeto estándar
            // $item = new pregunta(
            //     $obj->id_pregunta,
            //     $obj->pregunta,
            //     (array) $obj->respuestas,
            //     $obj->correcta
            // );

    //TODO Obtener una solo pregunta por id
    //TODO Actualizar una pregunta
    //TODO Eliminar

    // $pregunta = array(
    //     "id_pregunta" => 0,
    //     "pregunta" => "Cadena de texto de la pregunta...",
    //     "respuestas" => array(
    //         0 => "Respuesta...",
    //         1 => "Respuesta...",
    //         2 => "Respuesta...",
    //         3 => "Respuesta..."
    //     ),
    //     "correcta" => 1
    // );
}