<?php
# empleado.php

require_once "bd.php";

class empleado {
    //Atributos
    public $id_empleado;
    public $nombre;
    public $apellidos;
    public $telefono;
    public $dni;

    //Atributos de la clase
    private static $table = "empleados"; //Se tiene que llamar como la tabla de la BBDD

    public function __construct(
        $id_empleado = null,
        $nombre = "",
        $apellidos = "",
        $telefono = "",
        $dni = ""
    ) {
        $this->id_empleado = $id_empleado;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->telefono = $telefono;
        $this->dni = $dni;
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
                $salida[] = new empleado(
                    $item["id_empleado"],
                    $item["nombre"],
                    $item["apellidos"],
                    $item["telefono"],
                    $item["dni"]
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
                return new empleado(
                    $items[0]["id_empleado"],
                    $items[0]["nombre"],
                    $items[0]["apellidos"],
                    $items[0]["telefono"],
                    $items[0]["dni"]
                );
            }
            else {
                return null;
            }
        }
    }

    public function deleteById() {
        return bd::deleteById(self::$table, $this->id_empleado);
    }

    public function save() {
        $conn = bd::get();
        if (!($conn instanceof PDO)) return null;

        //Inserción
        if ($this->id_empleado == null) {
            $sql = 'INSERT INTO '.self::$table.' (nombre, apellidos, telefono, dni)
            VALUES (:nombre, :apellidos, :telefono, :dni)';

            $stmt = $conn->prepare($sql); 

            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellidos', $this->apellidos);
            $stmt->bindParam(':telefono', $this->telefono);
            $stmt->bindParam(':dni', $this->dni);
            //Ejecuto
            $stmt->execute();
        }
        //Actualización
        else {
            $sql = 'UPDATE '.self::$table.' SET 
                nombre=:nombre,
                apellidos=:apellidos,
                telefono=:telefono,
                dni=:dni
                WHERE id_empleado=:id_empleado';

            $stmt = $conn->prepare($sql); 
            
            $stmt->bindParam(':id_empleado', $this->id_empleado);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellidos', $this->apellidos);
            $stmt->bindParam(':telefono', $this->telefono);
            $stmt->bindParam(':dni', $this->dni);
            
            $stmt->execute();
        }
        
        return $this;
    }
}

?>