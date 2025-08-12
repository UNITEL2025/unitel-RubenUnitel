<?php
# cliente.php

require_once "bd.php";
require_once "asociado.php";

class cliente {
    //Atributos
    public $id_cliente;
    public $notas;
    public $fecha;
    public $asociado_id;
    public $asociados;

    //Atributos de la clase
    private static $table = "clientes"; //Se tiene que llamar como la tabla de la BBDD

    public function __construct(
        $id_cliente = null,
        $notas = "",
        $fecha = "",
        $asociado_id = null,
        $asociados = array()
    ) {
        $this->id_cliente = $id_cliente;
        $this->notas = $notas;
        $this->fecha = $fecha;
        $this->asociado_id = $asociado_id;
        $this->asociados = $asociados;
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
                $salida[] = new cliente(
                    $item["id_cliente"],
                    $item["notas"],
                    $item["fecha"],
                    $item["asociado_id"],
                    self::getAsociados($item["id_cliente"])
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
                return new cliente(
                    $items[0]["id_cliente"],
                    $items[0]["notas"],
                    $items[0]["fecha"],
                    $items[0]["asociado_id"],
                    self::getAsociados($items[0]["id_cliente"])
                );
            }
            else {
                return null;
            }
        }
    }

    public function delete() {
        return bd::deleteById(self::$table, $this->id_cliente);
    }

    public function save() {
        $conn = bd::get();
        if (!($conn instanceof PDO)) return null;

        //Inserción
        if ($this->id_cliente == null) {
            $sql = 'INSERT INTO '.self::$table.' (notas)
            VALUES (:notas)';

            $stmt = $conn->prepare($sql); 
            $stmt->bindParam(':notas', $this->notas);
            $stmt->execute(); //Ejecuto
            $last_id = $conn->lastInsertId(); //Necesitamos el último id
            $this->id_cliente = $last_id;
            
            foreach ($this->asociados as $asociado) {
                $asociado->cliente_id = $last_id;
                $asociado->save();
            }
        }
        //Actualización
        else {
            $sql = 'UPDATE '.self::$table.' SET 
                notas=:notas,
                asociado_id=:asociado_id
                WHERE id_cliente=:id_cliente';

            $stmt = $conn->prepare($sql); 
            
            $stmt->bindParam(':id_cliente', $this->id_cliente);
            $stmt->bindParam(':notas', $this->notas);
            $stmt->bindParam(':asociado_id', $this->asociado_id);
            
            $stmt->execute();

            foreach ($this->asociados as $asociado) {
                $asociado->save();
            }
        }
        
        return $this;
    }

    public static function getAsociados(int $id_cliente) {
        if ($id_cliente !== null)
        {
            return asociado::getAllByClienteId($id_cliente);
        }
        else {
            return array();
        }
    }

    public function getTitular() {
        foreach ($this->asociados as $asociado) {
            if ($this->asociado_id == $asociado->id_asociado) {
                return $asociado;
            }
        }
        return null;
        //Cómo usarla? => $cliente->getTitular()->nombre;
    }

    public function getTitularNombre() {
        if (count($this->asociados) > 0) {
            $titular = $this->getTitular();
            if ($titular == null) return "";
            else return $titular->nombre;
        }
        else {
            return "";
        }       
    }

    public function getTitularDni() {
        if (count($this->asociados) > 0) {
            $titular = $this->getTitular();
            if ($titular == null) return "";
            else return $titular->dni;
        }
        else {
            return "";
        }       
    }
}

?>