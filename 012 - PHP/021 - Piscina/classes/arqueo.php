<?php
# arqueo.php

require_once "bd.php";

class arqueo {
    //Atributos
    public $id_arqueo;
    public $empleado_id;
    public $fondo;
    public $ventas;
    public $descuadre;
    public $fecha_ini;
    public $fecha_fin;
    public $cto1;
    public $cto2;
    public $cto5;
    public $cto10;
    public $cto20;
    public $cto50;
    public $euro1;
    public $euro2;
    public $euro5;
    public $euro10;
    public $euro20;
    public $euro50;

    //Atributos de la clase
    private static $table = "arqueos"; //Se tiene que llamar como la tabla de la BBDD

    public function __construct(
        $id_arqueo = null,
        $empleado_id = null,
        $fondo = null,
        $ventas = null,
        $descuadre = null,
        $fecha_ini = null,
        $fecha_fin = null,
        $cto1 = null,
        $cto2 = null,
        $cto5 = null,
        $cto10 = null,
        $cto20 = null,
        $cto50 = null,
        $euro1 = null,
        $euro2 = null,
        $euro5 = null,
        $euro10 = null,
        $euro20 = null,
        $euro50 = null
    ) {
        $this->id_arqueo = $id_arqueo;
        $this->empleado_id = $empleado_id;
        $this->fondo = $fondo;
        $this->ventas = $ventas;
        $this->descuadre = $descuadre;
        $this->fecha_ini = $fecha_ini;
        $this->fecha_fin = $fecha_fin;
        $this->cto1 = $cto1;
        $this->cto2 = $cto2;
        $this->cto5 = $cto5;
        $this->cto10 = $cto10;
        $this->cto20 = $cto20;
        $this->cto50 = $cto50;
        $this->euro1 = $euro1;
        $this->euro2 = $euro2;
        $this->euro5 = $euro5;
        $this->euro10 = $euro10;
        $this->euro20 = $euro20;
        $this->euro50 = $euro50;
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
                $salida[] = new arqueo(
                    $item["id_arqueo"],
                    $item["empleado_id"],
                    $item["fondo"],
                    $item["ventas"],
                    $item["descuadre"],
                    $item["fecha_ini"],
                    $item["fecha_fin"],
                    $item["1cto"],
                    $item["2cto"],
                    $item["5cto"],
                    $item["10cto"],
                    $item["20cto"],
                    $item["50cto"],
                    $item["1euro"],
                    $item["2euro"],
                    $item["5euro"],
                    $item["10euro"],
                    $item["20euro"],
                    $item["50euro"]
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
                return new arqueo(
                    $items[0]["id_arqueo"],
                    $items[0]["empleado_id"],
                    $items[0]["fondo"],
                    $items[0]["ventas"],
                    $items[0]["descuadre"],
                    $items[0]["fecha_ini"],
                    $items[0]["fecha_fin"],
                    $items[0]["1cto"],
                    $items[0]["2cto"],
                    $items[0]["5cto"],
                    $items[0]["10cto"],
                    $items[0]["20cto"],
                    $items[0]["50cto"],
                    $items[0]["1euro"],
                    $items[0]["2euro"],
                    $items[0]["5euro"],
                    $items[0]["10euro"],
                    $items[0]["20euro"],
                    $items[0]["50euro"]
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
        if ($this->id_arqueo == null) {
            $sql = 'INSERT INTO '.self::$table.' (
                empleado_id,
                fondo,
                ventas,
                descuadre,
                fecha_ini,
                fecha_fin,
                1cto,
                2cto,
                5cto,
                10cto,
                20cto,
                50cto,
                1euro,
                2euro,
                5euro,
                10euro,
                20euro,
                50euro)
            VALUES (
                :empleado_id,
                :fondo,
                :ventas,
                :descuadre,
                :fecha_ini,
                :fecha_fin,
                :1cto,
                :2cto,
                :5cto,
                :10cto,
                :20cto,
                :50cto,
                :1euro,
                :2euro,
                :5euro,
                :10euro,
                :20euro,
                :50euro
                )';

            $stmt = $conn->prepare($sql); 
            $stmt->bindParam(':empleado_id', $this->empleado_id);
            $stmt->bindParam(':fondo', $this->fondo);
            $stmt->bindParam(':ventas', $this->ventas);
            $stmt->bindParam(':descuadre', $this->descuadre);
            $stmt->bindParam(':fecha_ini', $this->fecha_ini);
            $stmt->bindParam(':fecha_fin', $this->fecha_fin);
            $stmt->bindParam(':1cto', $this->cto1);
            $stmt->bindParam(':2cto', $this->cto2);
            $stmt->bindParam(':5cto', $this->cto5);
            $stmt->bindParam(':10cto', $this->cto10);
            $stmt->bindParam(':20cto', $this->cto20);
            $stmt->bindParam(':50cto', $this->cto50);
            $stmt->bindParam(':1euro', $this->euro1);
            $stmt->bindParam(':2euro', $this->euro2);
            $stmt->bindParam(':5euro', $this->euro5);
            $stmt->bindParam(':10euro', $this->euro10);
            $stmt->bindParam(':20euro', $this->euro20);
            $stmt->bindParam(':50euro', $this->euro50);
            
            $stmt->execute(); //Ejecuto
            $last_id = $conn->lastInsertId(); //Necesitamos el último id
            $this->id_arqueo = $last_id;
            
        }
        //Actualización
        else {
            $sql = 'UPDATE '.self::$table.' SET 
                empleado_id=:empleado_id,
                fondo=:fondo,
                ventas=:ventas,
                descuadre=:descuadre,
                fecha_ini=:fecha_ini,
                fecha_fin=:fecha_fin,
                1cto=:1cto,
                2cto=:2cto,
                5cto=:5cto,
                10cto=:10cto,
                20cto=:20cto,
                50cto=:50cto,
                1euro=:1euro,
                2euro=:2euro,
                5euro=:5euro,
                10euro=:10euro,
                20euro=:20euro,
                50euro=:50euro
                WHERE id_arqueo=:id_arqueo';

            $stmt = $conn->prepare($sql); 
            
            $stmt->bindParam(':id_arqueo', $this->id_arqueo);
            $stmt->bindParam(':empleado_id', $this->empleado_id);
            $stmt->bindParam(':fondo', $this->fondo);
            $stmt->bindParam(':ventas', $this->ventas);
            $stmt->bindParam(':descuadre', $this->descuadre);
            $stmt->bindParam(':fecha_ini', $this->fecha_ini);
            $stmt->bindParam(':fecha_fin', $this->fecha_fin);
            $stmt->bindParam(':1cto', $this->cto1);
            $stmt->bindParam(':2cto', $this->cto2);
            $stmt->bindParam(':5cto', $this->cto5);
            $stmt->bindParam(':10cto', $this->cto10);
            $stmt->bindParam(':20cto', $this->cto20);
            $stmt->bindParam(':50cto', $this->cto50);
            $stmt->bindParam(':1euro', $this->euro1);
            $stmt->bindParam(':2euro', $this->euro2);
            $stmt->bindParam(':5euro', $this->euro5);
            $stmt->bindParam(':10euro', $this->euro10);
            $stmt->bindParam(':20euro', $this->euro20);
            $stmt->bindParam(':50euro', $this->euro50);
            
            $stmt->execute();
        }
        
        return $this;
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
                return new arqueo(
                    $items[0]["id_arqueo"],
                    $items[0]["empleado_id"],
                    $items[0]["fondo"],
                    $items[0]["ventas"],
                    $items[0]["descuadre"],
                    $items[0]["fecha_ini"],
                    $items[0]["fecha_fin"],
                    $items[0]["1cto"],
                    $items[0]["2cto"],
                    $items[0]["5cto"],
                    $items[0]["10cto"],
                    $items[0]["20cto"],
                    $items[0]["50cto"],
                    $items[0]["1euro"],
                    $items[0]["2euro"],
                    $items[0]["5euro"],
                    $items[0]["10euro"],
                    $items[0]["20euro"],
                    $items[0]["50euro"]
                );
            }
        }
        return null;
    }
}

?>