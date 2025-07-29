<?php
class customer {
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $phone;
    public $notes;
    public $dateCreate;
    public $dateUpdate;

    public function __contruct(
        $id = null,
        $firstname = "",
        $lastname = "",
        $email = "",
        $phone = "",
        $note = "",
        $dateCreate = "",
        $dateUpdate = ""
    ) {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->phone = $phone;
        $this->note = $note;
        $this->dateCreate = $dateCreate;
        $this->dateUpdate = $dateUpdate;
    }

    public static function getById(int $id) {
        //1) Conectar con la BBDD
        //2) Hacer un SELECT con WHERE
        //3)Instanciar el objeto
        //4)Devolver el objeto

        $sql = 'SELECT * FROM customers WHERE id = :id';

        $conn = conn::open(); //Creo una instancia del conector
        if ($conn["status"] == true) { //Compruebo que la conexión se ha abierto bien
            //Preparo la conexión
            $stmt = $conn["conn"]->prepare($sql); 
            //Asigno valores
            $stmt->bindParam(':id', $id);
            //Ejecuto
            $stmt->execute();
            //Le indicamos que nos devuelva todos los resultados en un array asociativo
            $result = $stmt->fetchAll();
            //Comprobamos que mínimo tiene 1 elemento
            if (!empty($result) && isset($result[0])) {
                //Devolvemos el objeto instanciado
                $customer = new customer();
                $customer->id = $result[0]["id"];
                $customer->firstname = $result[0]["firstname"];
                $customer->lastname = $result[0]["lastname"];
                $customer->email = $result[0]["email"];
                $customer->phone = $result[0]["phone"];
                $customer->notes = $result[0]["notes"];
                $customer->dateCreate = $result[0]["dateCreate"];
                $customer->dateUpdate = $result[0]["dateUpdate"];

                return $customer;
            }
            else { //Devolvemos un null
                return null;
            }
        }
        //Si se abre mal -> error
        else {
            die('ERROR');
        }
    }

    public static function getAll() : array {
        //1) Conectar con la BBDD
        //2) Hacer un SELECT *
        //3) Meterlo en un array
        //4) Devolver el array
        $sql = 'SELECT * FROM customers';

        $conn = conn::open(); //Creo una instancia del conector
        if ($conn["status"] == true) { //Compruebo que la conexión se ha abierto bien
            //Preparo la conexión
            $stmt = $conn["conn"]->prepare($sql); 
            //Ejecuto
            $stmt->execute();
            //Le indicamos que nos devuelva todos los resultados en un array asociativo
            $result = $stmt->fetchAll();
            //Comprobamos que mínimo tiene 1 elemento
            if (!empty($result)) {
                foreach ($result as $item) {
                    //Devolvemos el objeto instanciado
                    $customer = new customer();
                    $customer->id = $item["id"];
                    $customer->firstname = $item["firstname"];
                    $customer->lastname = $item["lastname"];
                    $customer->email = $item["email"];
                    $customer->phone = $item["phone"];
                    $customer->notes = $item["notes"];
                    $customer->dateCreate = $item["dateCreate"];
                    $customer->dateUpdate = $item["dateUpdate"];

                    $customers[] = $customer;
                }
                return $customers;               
            }
            else { //Devolvemos un array vacío
                return array();
            }
        }
        //Si se abre mal -> error
        else {
            die('ERROR');
        }
    }

    public function save() {
        $sql = ""; //Defino el str del sql
        //1) Comprobar si tiene id o no
        //2) Abrimos conexión
        //3) Ejecutamos la sentencia (update/insert)
        //1.1) Que NO tenga id -> Hay que insertar (INSERT)
        if ($this->id == null) {
            $sql = 'INSERT INTO customers (firstname, lastname, email, phone, notes)
            VALUES (:firstname, :lastname, :email, :phone, :notes)';

            $conn = conn::open(); //Creo una instancia del conector
            if ($conn["status"] == true) { //Compruebo que la conexión se ha abierto bien
                //Preparo la conexión
                $stmt = $conn["conn"]->prepare($sql); 
                //Asigno valores
                $stmt->bindParam(':firstname', $this->firstname);
                $stmt->bindParam(':lastname', $this->lastname);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':phone', $this->phone);
                $stmt->bindParam(':notes', $this->notes);
                //Ejecuto
                $stmt->execute();
            }
            //Si se abre mal -> error
            else {
                die('ERROR');
            }
        }
        //1.2) Que tenga id -> Hay que actualizar (UPDATE)
        else {
            $sql = 'UPDATE customers SET 
                firstname=:firstname,
                lastname=:lastname,
                email=:email,
                phone=:phone,
                notes=:notes
                WHERE id=:id';

            $conn = conn::open(); //Creo una instancia del conector
            if ($conn["status"] == true) { //Compruebo que la conexión se ha abierto bien
                //Preparo la conexión
                $stmt = $conn["conn"]->prepare($sql); 
                //Asigno valores
                $stmt->bindParam(':firstname', $this->firstname);
                $stmt->bindParam(':lastname', $this->lastname);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':phone', $this->phone);
                $stmt->bindParam(':notes', $this->notes);
                $stmt->bindParam(':id', $this->id);
                //Ejecuto
                $stmt->execute();
            }
        }
        //4) Devolver el objeto si hay sido OK, si ha habido fallo: devolver una cadena o devolver un null
    }

    public function deleteById() : bool {
        //1) Conectar la BBDD
        //2) Montar el sql y ejecutar
        //3) Opcional: Devolver la salida salida (true/false)

        return true;
    }

    //Función para crear datos dummies
    public static function setDummies() {
        for ($i=0; $i < 500; $i++) { 
            $item = new customer();
            $item->firstname = "Nombre ".$i;
            $item->lastname = "Apellido ".$i." Apellido ".$i;
            $item->phone = "6".str_pad((string) $i, 8, "0", STR_PAD_LEFT);
            $item->email = "email".$i."@domain.es";
            $item->notes = "Nota del cliente: ".$i;
            $item->save();
        }
    }
}
?>