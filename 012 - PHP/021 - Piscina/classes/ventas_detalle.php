<?php
# ventas_detalle.php

require_once "bd.php";

class detalle {
    //Atributos
    public $id_venta_detalle;
    public $venta_id;
    public $producto_id;
    public $precio;
    public $ctd;
    public $referencias;

    //Atributos de la clase
    public static $table = "ventas_detalle"; //Se tiene que llamar como la tabla de la BBDD

    public function __construct(
        $id_venta_detalle = null,
        $venta_id = null,
        $producto_id = null,
        $precio = 0,
        $ctd = 0,
        $referencias = array()
    ) {
        $this->id_venta_detalle = $id_venta_detalle;
        $this->venta_id = $venta_id;
        $this->producto_id = $producto_id;
        $this->precio = $precio;
        $this->ctd = $ctd;
        $this->referencias = $referencias;
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
                $salida[] = new detalle(
                    $item["id_venta_detalle"],
                    $item["venta_id"],
                    $item["producto_id"],
                    $item["precio"],
                    $item["ctd"],
                    self::getReferencias($item["id_venta_detalle"])
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
                return new detalle(
                    $item["id_venta_detalle"],
                    $item["venta_id"],
                    $item["producto_id"],
                    $item["precio"],
                    $item["ctd"],
                    self::getReferencias($item["id_venta_detalle"])
                );
            }
            else {
                return null;
            }
        }
    }

    public function deleteById() {
        return bd::deleteById(self::$table, $this->id_venta_detalle);
    }

    public function save() {
        $conn = bd::get();
        if (!($conn instanceof PDO)) return null;

        //Inserción
        if ($this->id_venta_detalle == null) {
            $sql = 'INSERT INTO '.self::$table.' (venta_id, producto_id, precio, ctd)
            VALUES (:venta_id, :producto_id, :precio, :ctd)';

            $stmt = $conn->prepare($sql); 
            $stmt->bindParam(':venta_id', $this->venta_id);
            $stmt->bindParam(':producto_id', $this->producto_id);
            $stmt->bindParam(':precio', $this->precio);
            $stmt->bindParam(':ctd', $this->ctd);
            $stmt->execute(); //Ejecuto

            $last_id = $conn->lastInsertId(); //Necesitamos el último id

            for ($i=0; $i < $this->ctd; $i++) {
                $referencia = new referencia();
                $referencia->detalle_id = $last_id;
                $referencia->referencia = referencia::getNext($this->producto_id);
                $referencia->save();
            }
        }
        //Actualización
        else {
            $sql = 'UPDATE '.self::$table.' SET 
                venta_id=:venta_id,
                producto_id=:producto_id,
                precio=:precio,
                ctd=:ctd
                WHERE id_venta_detalle=:id_venta_detalle';

            $stmt = $conn->prepare($sql); 
            
            $stmt->bindParam(':id_venta_detalle', $this->id_venta_detalle);
            $stmt->bindParam(':venta_id', $this->venta_id);
            $stmt->bindParam(':producto_id', $this->producto_id);
            $stmt->bindParam(':precio', $this->precio);
            $stmt->bindParam(':ctd', $this->ctd);
            
            $stmt->execute();

            foreach ($this->referencias as $referencia) {
                $referencia->save();
            }
        }
        
        return $this;
    }

    public static function getAllByVentaId(int $venta_id) {
        $salida = array();
        $sql = 'SELECT * FROM '.self::$table.' WHERE venta_id = :venta_id';

        $conn = bd::get();
        if ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql); 
            $stmt->bindParam(':venta_id', $venta_id);
            $stmt->execute();
            $items = $stmt->fetchAll();

            foreach ($items as $item) {
                $salida[] = new detalle(
                    $item["id_venta_detalle"],
                    $item["venta_id"],
                    $item["producto_id"],
                    $item["precio"],
                    $item["ctd"]
                );
            }

            return $salida;
        }
        else {
            return null;
        }
    }

    public static function getReferencias(int $id_detalle) {
        if ($id_detalle !== null)
        {
            return referencia::getAllByDetalleId($id_detalle);
        }
        else {
            return array();
        }
    }
}

?>