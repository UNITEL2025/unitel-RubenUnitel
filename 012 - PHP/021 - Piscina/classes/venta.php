<?php
# venta.php

require_once "bd.php";

class venta {
    //Atributos
    public $id_venta;
    public $fecha;
    public $cliente_id;
    public $empleado_id;
    public $metodo_pago;
    public $detalles;

    //Atributos de la clase
    private static $table = "ventas"; //Se tiene que llamar como la tabla de la BBDD
    public static $metodos = array(
        0 => "EFECTIVO",
        1 => "TARJETA",
        2 => "BIZUM"
    );

    public function __construct(
        $id_venta = null,
        $fecha = "",
        $cliente_id = null,
        $empleado_id = null,
        $metodo_pago = "",
        $detalles = array()
    ) {
        $this->id_venta = $id_venta;
        $this->fecha = $fecha;
        $this->cliente_id = $cliente_id;
        $this->empleado_id = $empleado_id;
        $this->metodo_pago = $metodo_pago;
        $this->detalles = $detalles;
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
                $salida[] = new venta(
                    $item["id_venta"],
                    $item["fecha"],
                    $item["cliente_id"],
                    $item["empleado_id"],
                    $item["metodo_pago"],
                    self::getDetalles($item["id_venta"])
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
                return new venta(
                    $item["id_venta"],
                    $item["fecha"],
                    $item["cliente_id"],
                    $item["empleado_id"],
                    $item["metodo_pago"],
                    self::getDetalles($item["id_venta"])
                );
            }
            else {
                return null;
            }
        }
    }

    public function deleteById() {
        return bd::deleteById(self::$table, $this->id_venta);
    }

    public function save() {
        $conn = bd::get();
        if (!($conn instanceof PDO)) return null;

        //Inserción
        if ($this->id_venta == null) {
            $sql = 'INSERT INTO '.self::$table.' (cliente_id, empleado_id, metodo_pago)
            VALUES (:cliente_id, :empleado_id, :metodo_pago)';

            $stmt = $conn->prepare($sql); 
            $stmt->bindParam(':cliente_id', $this->cliente_id);
            $stmt->bindParam(':empleado_id', $this->empleado_id);
            $stmt->bindParam(':metodo_pago', $this->metodo_pago);
            $stmt->execute(); //Ejecuto
            $last_id = $conn->lastInsertId(); //Necesitamos el último id
            
            foreach ($this->detalles as $detalle) {
                $detalle->venta_id = $last_id;
                $detalle->save();
            }
        }
        //Actualización
        else {
            $sql = 'UPDATE '.self::$table.' SET 
                cliente_id=:cliente_id,
                empleado_id=:empleado_id,
                metodo_pago=:metodo_pago,
                fecha=:fecha
                WHERE id_venta=:id_venta';

            $stmt = $conn->prepare($sql); 
            
            $stmt->bindParam(':id_venta', $this->id_venta);
            $stmt->bindParam(':cliente_id', $this->cliente_id);
            $stmt->bindParam(':empleado_id', $this->empleado_id);
            $stmt->bindParam(':metodo_pago', $this->metodo_pago);
            $stmt->bindParam(':fecha', $this->fecha);
            
            $stmt->execute();

            foreach ($this->detalles as $detalle) {
                $detalle->save();
            }
        }
        
        return $this;
    }

    public static function getDetalles(int $id_venta) {
        if ($id_venta !== null)
        {
            return detalle::getAllByVentaId($id_venta);
        }
    }

    public function getTotal() {
        $total = 0;
        if (count($this->detalles) > 0)
        {
            foreach ($this->detalles as $detalle) {
                $total += $detalle->precio * $detalle->ctd;
            }
        }
        return $total;
    }
}

?>