<?php
# asociado.php

require_once "bd.php";

class asociado {
    //Atributos
    public $id_asociado;
    public $nombre;
    public $dni;
    public $notas;
    public $fecha;
    public $cliente_id;

    //Atributos de la clase
    private static $table = "asociados"; //Se tiene que llamar como la tabla de la BBDD

    public function __construct(
        $id_asociado = null,
        $nombre = "",
        $dni = "",
        $notas = "",
        $fecha = "",
        $cliente_id = null
    ) {
        $this->id_asociado = $id_asociado;
        $this->nombre = $nombre;
        $this->dni = $dni;
        $this->notas = $notas;
        $this->fecha = $fecha;
        $this->cliente_id = $cliente_id;
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
                $salida[] = new asociado(
                    $item["id_asociado"],
                    $item["nombre"],
                    $item["dni"],
                    $item["notas"],
                    $item["fecha"],
                    $item["cliente_id"]
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
                return new asociado(
                    $item["id_asociado"],
                    $item["nombre"],
                    $item["dni"],
                    $item["notas"],
                    $item["fecha"],
                    $item["cliente_id"]
                );
            }
            else {
                return null;
            }
        }
    }

    public function deleteById() {
        return bd::deleteById(self::$table, $this->id_asociado);
    }

    public function save() {
        $conn = bd::get();
        if (!($conn instanceof PDO)) return null;

        //Inserción
        if ($this->id_asociado == null) {
            $sql = 'INSERT INTO '.self::$table.' (nombre, dni, notas, cliente_id)
            VALUES (:nombre, :dni, :notas, :cliente_id)';

            $stmt = $conn->prepare($sql); 
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':dni', $this->dni);
            $stmt->bindParam(':notas', $this->notas);
            $stmt->bindParam(':cliente_id', $this->cliente_id);
            $stmt->execute(); //Ejecuto
        }
        //Actualización
        else {
            $sql = 'UPDATE '.self::$table.' SET 
                nombre=:nombre,
                dni=:dni,
                notas=:notas,
                cliente_id=:cliente_id,
                fecha=:fecha
                WHERE id_asociado=:id_asociado';

            $stmt = $conn->prepare($sql); 
            
            $stmt->bindParam(':id_asociado', $this->id_asociado);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':dni', $this->dni);
            $stmt->bindParam(':notas', $this->notas);
            $stmt->bindParam(':cliente_id', $this->cliente_id);
            $stmt->bindParam(':fecha', $this->fecha);
            
            $stmt->execute();
        }
        
        return $this;
    }

    public static function getAllByClienteId(int $cliente_id) {
        $salida = array();
        $sql = 'SELECT * FROM '.self::$table.' WHERE cliente_id = :cliente_id';

        $conn = bd::get();
        if ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql); 
            $stmt->bindParam(':cliente_id', $cliente_id);
            $stmt->execute();
            $items = $stmt->fetchAll();

            foreach ($items as $item) {
                $salida[] = new asociado(
                    $item["id_asociado"],
                    $item["nombre"],
                    $item["dni"],
                    $item["notas"],
                    $item["fecha"],
                    $item["cliente_id"]
                );
            }

            return $salida;
        }
        else {
            return null;
        }
    }
}

?>