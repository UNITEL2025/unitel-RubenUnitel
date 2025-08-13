<?php
# asistencia.php

require_once "bd.php";

class asistencia {
    //Atributos
    public $id_asistencia;
    public $empleado_id;
    public $fecha_ini;
    public $fecha_fin;
    //Virtual
    public $empleado;

    //Atributos de la clase
    private static $table = "asistencias"; //Se tiene que llamar como la tabla de la BBDD

    public function __construct(
        $empleado_id,
        $id_asistencia = null,
        $fecha_ini = null,
        $fecha_fin = null,
        $empleado = null
    ) {
        $this->id_asistencia = $id_asistencia;
        $this->empleado_id = $empleado_id;
        $this->fecha_ini = $fecha_ini;
        $this->fecha_fin = $fecha_fin;
        $this->empleado = empleado::getById($this->empleado_id);
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
                $salida[] = new asistencia(
                    $item["empleado_id"],
                    $item["id_asistencia"],
                    $item["fecha_ini"],
                    $item["fecha_fin"],
                    empleado::getById($items[0]["empleado_id"])
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
                return new asistencia(
                    $items[0]["empleado_id"],
                    $items[0]["id_asistencia"],
                    $items[0]["fecha_ini"],
                    $items[0]["fecha_fin"],
                    empleado::getById($items[0]["empleado_id"])
                );
            }
            else {
                return null;
            }
        }
    }

    public function delete() {
        return bd::deleteById(self::$table, $this->id_asistencia);
    }

    public function save() {
        $conn = bd::get();
        if (!($conn instanceof PDO)) return null;

        //Inserción
        if ($this->id_asistencia == null) {
            $sql = 'INSERT INTO '.self::$table.' (empleado_id, fecha_ini)
            VALUES (:empleado_id, :fecha_ini)';

            $stmt = $conn->prepare($sql); 
            $stmt->bindParam(':empleado_id', $this->empleado_id);
            $stmt->bindParam(':fecha_ini', $this->fecha_ini);
            $stmt->execute(); //Ejecuto
        }
        //Actualización
        else {
            $sql = 'UPDATE '.self::$table.' SET 
                empleado_id=:empleado_id,
                fecha_ini=:fecha_ini,
                fecha_fin=:fecha_fin
                WHERE id_asistencia=:id_asistencia';

            $stmt = $conn->prepare($sql); 
            
            $stmt->bindParam(':id_asistencia', $this->id_asistencia);
            $stmt->bindParam(':empleado_id', $this->empleado_id);
            $stmt->bindParam(':fecha_ini', $this->fecha_ini);
            $stmt->bindParam(':fecha_fin', $this->fecha_fin);
            
            $stmt->execute();
        }
        
        return $this;
    }

    public function close() {
        $now = new \DateTime();
        $this->fecha_fin = $now->format("Y-m-d H:i:s");
        $this->save();
    }

    public static function getCurrent() {
        $sql = 'SELECT * FROM '.self::$table.' WHERE fecha_fin IS NULL LIMIT 1;';

        $conn = bd::get();
        if ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql); 
            $stmt->execute();
            $items = $stmt->fetchAll();

            if (!empty($items))
            {
                return new asistencia(
                    $items[0]["empleado_id"],
                    $items[0]["id_asistencia"],
                    $items[0]["fecha_ini"],
                    $items[0]["fecha_fin"],
                    empleado::getById($items[0]["empleado_id"])
                );
            }
        }
        return null;
    }
}

?>