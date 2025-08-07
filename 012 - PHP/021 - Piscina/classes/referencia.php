<?php
# referencia.php

require_once "bd.php";
require_once "classes/ventas_detalle.php";

class referencia {
    //Atributos
    public $id_detalle_ref;
    public $detalle_id;
    public $referencia;

    //Atributos de la clase
    private static $table = "detalle_ref"; //Se tiene que llamar como la tabla de la BBDD

    public function __construct(
        $id_detalle_ref = null,
        $detalle_id = null,
        $referencia = 0
    ) {
        $this->id_detalle_ref = $id_detalle_ref;
        $this->detalle_id = $detalle_id;
        $this->referencia = $referencia;
    }

    public function save() {
        $conn = bd::get();
        if (!($conn instanceof PDO)) return null;

        //Inserción
        if ($this->id_detalle_ref == null) {
            $sql = 'INSERT INTO '.self::$table.' (detalle_id, referencia)
            VALUES (:detalle_id, :referencia)';

            $stmt = $conn->prepare($sql); 

            $stmt->bindParam(':detalle_id', $this->detalle_id);
            $stmt->bindParam(':referencia', $this->referencia);
            //Ejecuto
            $stmt->execute();
        }
        //Actualización
        else {
            $sql = 'UPDATE '.self::$table.' SET 
                detalle_id=:detalle_id,
                referencia=:referencia
                WHERE id_detalle_ref=:id_detalle_ref';

            $stmt = $conn->prepare($sql); 
            
            $stmt->bindParam(':id_detalle_ref', $this->id_detalle_ref);
            $stmt->bindParam(':detalle_id', $this->detalle_id);
            $stmt->bindParam(':referencia', $this->referencia);
            
            $stmt->execute();
        }
        
        return $this;
    }

    public static function getAllByDetalleId(int $detalle_id) {
        $salida = array();
        $sql = 'SELECT * FROM '.self::$table.' WHERE detalle_id = :detalle_id';

        $conn = bd::get();
        if ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql); 
            $stmt->bindParam(':detalle_id', $detalle_id);
            $stmt->execute();
            $items = $stmt->fetchAll();

            foreach ($items as $item) {
                $salida[] = new referencia(
                    $item["id_detalle_ref"],
                    $item["detalle_id"],
                    $item["referencia"]
                );
            }

            return $salida;
        }
        else {
            return null;
        }
    }

    public static function getNext(int $id_producto)
    {
        $salida = 0;
        $sql = 'SELECT MAX(r.referencia) as max_ref FROM '.detalle::$table.' as vd '.
        'LEFT JOIN '.self::$table.' as r ON vd.id_venta_detalle = r.detalle_id '.
        'WHERE vd.producto_id = :id_producto';

        $conn = bd::get();
        if ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql); 
            $stmt->bindParam(':id_producto', $id_producto);
            $stmt->execute();
            $items = $stmt->fetchAll();

            //Si es nulo -> Entonces no hay detalles de venta aún
            //Entonces hay que buscar la ref inicial del producto
            if ($items[0]["max_ref"] == null) {
                $producto = producto::getById($id_producto);
                $salida = $producto->ref_ini + 1;
            }
            //Otro caso es que ya existan detalles de ventas, por tanto hay que buscar el máximo
            else {
                $salida = $items[0]["max_ref"] + 1;
            }
            
            return $salida;
        }
        else {
            return null;
        }
    }
}

?>