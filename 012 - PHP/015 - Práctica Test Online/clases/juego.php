<?php

require_once "tools/files.php";
require_once "clases/pregunta.php";

class juego {
    public $id_juego; //AUTO Único
    public $id_jugador;//Sobra
    public $step;//El paso por el que va el jugador
    public $name;//Nombre del jugador
    public $test;//getTest()
    public $last_ask;//última pregunta que hecho usuario
    public $respuestas;//Respuestas del usuario

    private static $filename = "juegos.txt"; //Defino el archivo del juego

    public function __construct(
        $id_juego = null,
        $id_jugador = null,
        $step = 0,
        $name = "",
        $test = array(),
        $last_ask = 0,
        $respuestas = array()
    ) {
        $this->id_juego = $id_juego;
        $this->id_jugador = $id_jugador;
        $this->step = $step;
        $this->name = $name;
        $this->test = $test;

        //Opción si el id == null
        if (empty($this->test)) { //Esto es lo mismo count($this->test) == 0
            foreach (pregunta::getTest() as $item) {
                $this->test[] = $item->id_pregunta;
            }
        }

        $this->last_ask = $last_ask;
        $this->respuestas = $respuestas;
    }

    public function toJSON(): string {
        return json_encode($this);
    }

    public function save(): void {
        if ($this->id_juego === null) {
            $this->id_juego = self::getNextId();
        }

        $items = files::read(self::$filename);
        $found = false;

        foreach ($items as $i => $item) {
            $obj = json_decode($item);
            if ($obj !== null && $obj->id_juego == $this->id_juego) {
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

    public static function getNextId(): int {
        $items = files::read(self::$filename);
        $max_id = -1;

        foreach ($items as $item) {
            $obj = json_decode($item);
            if ($obj !== null && isset($obj->id_juego) && $obj->id_juego > $max_id) {
                $max_id = $obj->id_juego;
            }
        }

        return $max_id + 1;
    }

    public static function getAll(): array {
        $salida = [];

        $items = files::read(self::$filename);
        foreach ($items as $item) {
            $obj = json_decode($item);
            if ($obj !== null) {
                $salida[] = new juego(
                    $obj->id_juego,
                    $obj->id_jugador,
                    $obj->step,
                    $obj->name,
                    $obj->test,
                    $obj ->last_ask,
                    $obj->respuestas
                );
            }
        }

        return $salida;
    }

    public static function getById(int $id): juego {
        foreach (files::read(self::$filename) as $item) {
            $obj = json_decode($item);
            if ($obj !== null && $obj->id_juego == $id) {
                return new juego(
                    $obj->id_juego,
                    $obj->id_jugador,
                    $obj->step,
                    $obj->name,
                    $obj->test,
                    $obj->last_ask,
                    $obj->respuestas
                );
            }
        }

        return new juego();
    }

    public static function deleteAll(): void {
        files::delete(self::$filename);
    }

    public function getResume(): array {
        $aciertos = 0;
        foreach ($this->test as $i => $id_pregunta) {
            $preg = pregunta::getById($id_pregunta);
            if (isset($this->respuestas[$i]) && $this->respuestas[$i] == $preg->correcta) {
                $aciertos++;
            }
        }

        return array(
            "total" => count($this->test),
            "aciertos" => $aciertos
        );
    }
}
