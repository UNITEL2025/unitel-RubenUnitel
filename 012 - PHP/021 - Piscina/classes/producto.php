<?php
# producto.php

require_once "bd.php";

class producto {
    //Atributos
    public $id_producto;
    public $nombre;
    public $precio;
    public $notas;
    public $tipo;
    public $ref_ini;
    public $fecha;
    public $fecha_ini;
    public $fecha_fin;

    //Atributos de la clase
    private static $table = "productos"; //Se tiene que llamar como la tabla de la BBDD

    public function __construct(
        $id_producto = null,
        $nombre = "",
        $precio = 0,
        $notas = "",
        $tipo = FALSE,
        $ref_ini = 0,
        $fecha = "",
        $fecha_ini = "",
        $fecha_fin = "",
    ) {
        $this->id_producto = $id_producto;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->notas = $notas;
        $this->tipo = $tipo;
        $this->ref_ini = $ref_ini;
        $this->fecha = $fecha;
        $this->fecha_ini = $fecha_ini;
        $this->fecha_fin = $fecha_fin;
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
                $salida[] = new producto(
                    $item["id_producto"],
                    $item["nombre"],
                    $item["precio"],
                    $item["notas"],
                    $item["tipo"],
                    $item["ref_ini"],
                    $item["fecha"],
                    $item["fecha_ini"],
                    $item["fecha_fin"]
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
                return new producto(
                    $items[0]["id_producto"],
                    $items[0]["nombre"],
                    $items[0]["precio"],
                    $items[0]["notas"],
                    $items[0]["tipo"],
                    $items[0]["ref_ini"],
                    $items[0]["fecha"],
                    $items[0]["fecha_ini"],
                    $items[0]["fecha_fin"]
                );
            }
            else {
                return null;
            }
        }
    }

    public function deleteById() {
        return bd::deleteById(self::$table, $this->id_producto);
    }

    public function save() {
        $conn = bd::get();
        if (!($conn instanceof PDO)) return null;

        //Inserción
        if ($this->id_producto == null) {
            $sql = 'INSERT INTO '.self::$table.' 
            (nombre, precio, notas, tipo, ref_ini, fecha_ini, fecha_fin)
            VALUES (
            :nombre,
            :precio,
            :notas,
            :tipo,
            :ref_ini,
            :fecha_ini,
            :fecha_fin)';

            $stmt = $conn->prepare($sql); 

            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':precio', $this->precio);
            $stmt->bindParam(':notas', $this->notas);
            $stmt->bindParam(':tipo', $this->tipo);
            $stmt->bindParam(':ref_ini', $this->ref_ini);
            $stmt->bindParam(':fecha_ini', $this->fecha_ini);
            $stmt->bindParam(':fecha_fin', $this->fecha_fin);

            //Ejecuto
            $stmt->execute();
        }
        //Actualización
        else {
            $sql = 'UPDATE '.self::$table.' SET 
                nombre=:nombre,
                precio=:precio,
                notas=:notas,
                tipo=:tipo,
                ref_ini=:ref_ini,
                fecha_ini=:fecha_ini,
                fecha_fin=:fecha_fin
                WHERE id_producto=:id_producto';

            $stmt = $conn->prepare($sql); 
            
            $stmt->bindParam(':id_producto', $this->id_producto);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':precio', $this->precio);
            $stmt->bindParam(':notas', $this->notas);
            $stmt->bindParam(':tipo', $this->tipo);
            $stmt->bindParam(':ref_ini', $this->ref_ini);
            $stmt->bindParam(':fecha_ini', $this->fecha_ini);
            $stmt->bindParam(':fecha_fin', $this->fecha_fin);
            
            $stmt->execute();
        }
        
        return $this;
    }

    public static function getToday() {
        $now = new \DateTime();

        $sql = 'SELECT * 
                FROM '.self::$table.' 
                WHERE fecha_ini < "'.$now->format("Y-m-d").' 00:00:00" AND 
                fecha_fin > "'.$now->format("Y-m-d").' 23:59:59";';

        $conn = bd::get();
        if ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql); 
            $stmt->execute();
            return $stmt->fetchAll();
        }
        else {
            return array();
        }
    }
}

?>