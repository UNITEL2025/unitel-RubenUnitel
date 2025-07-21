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
        $this->id_pregunta = $id_pregunta;
        $this->pregunta = $pregunta;
        $this->respuestas = $respuestas;
        $this->correcta = $correcta;
    }

    //Guardar una pregunta (permanentemente)
    //TODO Hacer parte de update
    function save() {
        //1. Si la pregunta no tiene id, entonces buscamos el último
        if ($this->id_pregunta == null)
        {
            $this->id_pregunta = $this->getLastId();
        }
        //2. Abrir el archivo
        $myfile = fopen($this->filename, "a") or die("Unable to open file!");
        //3.Escribir
        fwrite($myfile, $this->toJSON()."\n");
        //4. Cerrar archivo
        fclose($myfile);
    }

    //Transforma el objeto en UN JSON
    function toJSON() : string {
        return json_encode($this);
    }

    function getLastId() : int {
        //Obtenemos el número total de preguntas
        return count($this->getAll());
    }

    //Obtener todas las preguntas en formato JSON
    function getAll() : array {
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
                //Descodificamos la cadena JSON en un objeto estándar
                $obj = json_decode($value);

                //Instanciar una pregunta desde el objeto estándar
                $item = new pregunta(
                     $obj->id_pregunta,
                     $obj->pregunta,
                     (array) $obj->respuestas,
                     $obj->correcta
                );

                //Asigamos el objeto al array de salida
                $salida[] = $item;
            }
        }
        //3. Devolver el array de preguntas
        return $salida;
    }

    //Obtener una solo pregunta por id
    function getById() : pregunta {
        //1. Obtener todas las preguntas -> GetAll()
        //2. Localizar la pregunta con un bucle
        //2.1 Si la encuentra devolverla
        //2.2 Si no la encuentra -> Devolver una instaqncia de pregunta vacía
    }
    //TODO Actualizar una pregunta
    //TODO Eliminar
}