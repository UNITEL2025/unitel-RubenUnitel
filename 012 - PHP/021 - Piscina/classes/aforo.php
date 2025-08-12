<?php
# aforo.php

require_once "bd.php";

class aforo {
    //Atributos
    public $id_aforo;
    public $fecha;
    public $ctd;

    //Atributos de la clase
    private static $table = "aforos"; //Se tiene que llamar como la tabla de la BBDD

    public function __construct(
        $id_aforo = null,
        $ctd = 1,
        $fecha = null
    ) {
        $this->id_aforo = $id_aforo;
        $this->ctd = $ctd;
        $this->fecha = $fecha;
    }

    public static function getAll() {
        $salida = array();
        $items = bd::getAll(self::$table);
        if ($items == null)
        {
            return null;
        }
        else {
            foreach ($items as $item) {
                $salida[] = new aforo(
                    $item["id_aforo"],
                    $item["fecha"],
                    $item["ctd"]
                );
            }
            return $salida;
        }
    }

    public static function getById(int $id) {
        $items = bd::getById(self::$table, $id);
        if ($items == null)
        {
            return null;
        }
        else {
            if (!empty($items))
            {
                return new aforo(
                    $items[0]["id_aforo"],
                    $items[0]["fecha"],
                    $items[0]["ctd"]
                );
            }
            else {
                return null;
            }
        }
    }

    public function deleteById() {
        return bd::deleteById(self::$table, $this->id_cliente);
    }

    public function save() {
        $conn = bd::get();
        if (!($conn instanceof PDO)) return null;

        //Inserción
        if ($this->id_aforo == null) {
            $sql = 'INSERT INTO '.self::$table.' (ctd, fecha)
            VALUES (:ctd, :fecha)';

            $stmt = $conn->prepare($sql); 
            $stmt->bindParam(':ctd', $this->ctd);
            if ($this->fecha == null) $this->fecha = now();
            $stmt->bindParam(':fecha', $this->fecha);
            $stmt->execute(); //Ejecuto
        }
        //Actualización
        else {
            $sql = 'UPDATE '.self::$table.' SET 
                ctd=:ctd,
                fecha=:fecha
                WHERE id_aforo=:id_aforo';

            $stmt = $conn->prepare($sql); 
            
            $stmt->bindParam(':id_aforo', $this->id_aforo);
            $stmt->bindParam(':ctd', $this->ctd);
            $stmt->bindParam(':fecha', $this->fecha);
            
            $stmt->execute();

            foreach ($this->asociados as $asociado) {
                $asociado->save();
            }
        }
        
        return $this;
    }
}

?>