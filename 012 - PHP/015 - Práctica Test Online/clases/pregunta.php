<?php

require_once "tools/files.php";

class pregunta {
    // Propiedades
    public $id_pregunta; // Auto Incrementado
    public $pregunta;
    public $respuestas;
    public $correcta;

    // Propiedad genérica
    private static $filename = "preguntas.txt";

    // Constructor
    public function __construct(
        $id_pregunta = null,
        string $pregunta = "",
        array $respuestas = [],
        int $correcta = 1
    ) {
        $this->id_pregunta = $id_pregunta;
        $this->pregunta = $pregunta;
        $this->respuestas = $respuestas;
        $this->correcta = $correcta;
    }

    // Convierte el objeto en JSON
    public function toJSON(): string {
        return json_encode($this);
    }

    // Guardar una pregunta (permanentemente)
    public function save(): void {
        if ($this->id_pregunta === null) {
            $this->id_pregunta = self::getNextId();
        }

        $items = files::read(self::$filename);

        // Decodificar, actualizar si ya existe (por id), o añadir
        $found = false;
        foreach ($items as $i => $item) {
            $obj = json_decode($item);
            if ($obj !== null && $obj->id_pregunta == $this->id_pregunta) {
                $items[$i] = $this->toJSON();
                $found = true;
                break;
            }
        }

        if (!$found) {
            $items[] = $this->toJSON();
        }

        files::write(self::$filename, $items);
    }

    // Obtener el próximo ID disponible
    public static function getNextId(): int {
        $items = files::read(self::$filename);
        $max_id = -1; // Comenzar desde -1 para que el primer ID sea 0

        foreach ($items as $item) {
            $obj = json_decode($item);
            if ($obj !== null && isset($obj->id_pregunta) && $obj->id_pregunta > $max_id) {
                $max_id = $obj->id_pregunta;
            }
        }

        return $max_id + 1;
    }


    // Obtener todas las preguntas
    public static function getAll(): array {
        $salida = [];

        $items = files::read(self::$filename);
        foreach ($items as $item) {
            $obj = json_decode($item);
            if ($obj !== null) {
                $salida[] = new pregunta(
                    $obj->id_pregunta,
                    $obj->pregunta,
                    (array)$obj->respuestas,
                    $obj->correcta
                );
            }
        }

        return $salida;
    }

    // Obtener una sola pregunta por ID
    public static function getById(int $id): pregunta {
        foreach (files::read(self::$filename) as $item) {
            $obj = json_decode($item);
            if ($obj !== null && $obj->id_pregunta == $id) {
                return new pregunta(
                    $obj->id_pregunta,
                    $obj->pregunta,
                    (array)$obj->respuestas,
                    $obj->correcta
                );
            }
        }

        return new pregunta(); // Retorna instancia vacía si no la encuentra
    }

    // Elimina todas las preguntas (vacía el archivo)
    public static function deleteAll(): void {
        files::delete(self::$filename);
    }

    // Crea preguntas de prueba
    public static function setDummies(int $total = 20): void {
        for ($i = 0; $i < $total; $i++) {
            $correcta = rand(0, 3);
            $pregunta = new pregunta(
                null,
                "¿Esta es mi pregunta? $i",
                [
                    "Respuesta 1 de P$i".(($correcta == 0) ? " [CORRECTA]" : ""),
                    "Respuesta 2 de P$i".(($correcta == 1) ? " [CORRECTA]" : ""),
                    "Respuesta 3 de P$i".(($correcta == 2) ? " [CORRECTA]" : ""),
                    "Respuesta 4 de P$i".(($correcta == 3) ? " [CORRECTA]" : "")
                ],
                $correcta
            );
            $pregunta->save();
        }
    }

    // Devuelve un array de objetos pregunta según el número que se le indique (los devuelve mezclados)
    public static function getTest(int $total = 5): array {
        $items = pregunta::getAll();
        shuffle($items);
        return array_slice($items, 0, $total);
    }
}
