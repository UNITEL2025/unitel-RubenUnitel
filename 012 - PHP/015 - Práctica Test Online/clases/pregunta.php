<?php

class pregunta {
    //Propiedad
    public $id_pregunta; //Auto Incrementado
    public $pregunta;
    public $respuestas;
    public $correcta;

    //Propiedad genérica
    private static $filename = "preguntas.txt";

    //Constructor
    function __construct (
        $id_pregunta = null,
        string $pregunta = "",
        array $respuestas = array(),
        int $correcta = 1
    ) {

        $this->id_pregunta = $id_pregunta;
        $this->pregunta = $pregunta;
        $this->respuestas = $respuestas;
        $this->correcta = $correcta;     
    }

    //Guardar una pregunta (permanentemente)
    //TODO Actualizar
    function save() {
        if ($this->id_pregunta === null) {
            $this->id_pregunta = self::getNextId();
        }

        // Mismo código de guardar (append si es nuevo, o actualizar si ya existe)
        //$preguntas = self::getAll();

        // Si existe actualizar
        /*$encontrado = false;
        foreach ($preguntas as &$p) {
            if ($p->id_pregunta == $this->id_pregunta) {
                $p = $this;
                $encontrado = true;
                break;
            }
        }
        if (!$encontrado) {
            $preguntas[] = $this;
        }*/

        // Guardar todo en archivo
        $fp = fopen(self::$filename, "a") or die("No se pudo abrir el archivo!");
        fwrite($fp, $this->toJSON() . "\n");
        /*foreach ($preguntas as $p) {
            fwrite($fp, $p->toJSON() . "\n");
        }*/
        fclose($fp);
    }

    //Transforma el objeto en UN JSON
    function toJSON() : string {
        return json_encode($this);
    }

    // Método estático para obtener el último ID disponible
    public static function getNextId(): int {
        $preguntas = self::getAll();
        $max_id = 0;
        foreach ($preguntas as $p) {
            if ($p->id_pregunta > $max_id) $max_id = $p->id_pregunta;
        }
        return $max_id + 1;
    }

    //Obtener todas las preguntas en formato JSON
    public static function getAll(): array {
        $salida = array();

        if (!file_exists(self::$filename) || filesize(self::$filename) == 0) {
            return $salida;
        }

        $myfile = fopen(self::$filename, "r") or die("Unable to open file!");

        while (($line = fgets($myfile)) !== false) {
            $line = trim($line);
            if ($line != "") {
                $obj = json_decode($line);
                if ($obj !== null) {
                    $item = new pregunta(
                        $obj->id_pregunta,
                        $obj->pregunta,
                        (array)$obj->respuestas,
                        $obj->correcta
                    );
                    $salida[] = $item;
                }
            }
        }

        fclose($myfile);

        return $salida;
    }

    //Obtener una solo pregunta por id
    function getById(int $id) : pregunta {
        //1. Obtener todas las preguntas -> GetAll()
        //2. Localizar la pregunta con un bucle
        foreach ($this->getAll() as $pregunta)
        {
            //2.1 Si la encuentra devolverla
            if ($id == $pregunta->id_pregunta)
            {
                return $pregunta;
            }
        }
        //2.2 Si no la encuentra -> Devolver una instancia vacía
        return new pregunta();
    }

    //Elimina todas las preguntas (vacía el archivo)
    function deleteAll() {
        $myfile = fopen($this->filename, "w") or die("Unable to open file!");
        /*foreach ($preguntas as $item) {
            fwrite($myfile, $item->toJSON()."\n");
        } */           
        fclose($myfile);
    }
}