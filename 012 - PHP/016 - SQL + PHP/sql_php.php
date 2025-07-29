<?php

    //Para poder usar PHP y mySQL nos hacen falta conectores sql
    //Tipos principales:
    //MySQLi extension (la "i" significa mejorado)
    //PDO (PHP Data Objects)

    # IMPORTANTE! Activar servidor SQL en XAMPP

    $servername = "localhost";
    $username = "root";
    $password = "";
    
    //MySqli
    //1er paso) Create connection
    //Estamos la instancia de la clase mysqli
    //$conn = new mysqli($servername, $username, $password);

    //2do paso) Check connection
    /*if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "mySqli: Connected successfully";*/

    //PDO
    //Además hay que definir otra variable
    //Que será la Base de Datos a la que nos queremos conectar
    $db = "sql_test";

    try {
        //Instanciamos la conexión PSO
        $conn = new PDO("mysql:host=$servername;dbname=".$db, $username, $password);
        //Para que indique avisos
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "PDO: Connected successfully";
    } catch(PDOException $e) {
        echo "PDO: Connection failed: " . $e->getMessage();
    }

    //Cuando acabamos de usar la BBDD, debemos cerrar la conexión
    //mySQLi
    //$conn->close();
    //mysqli_close($conn);

    //PDO
    //$conn = null;

    //Usaremos la clase PDO para trabajar con la BBDD
    //Creación de una Base de Datos
    //Sentencia SQL
    $sql = "CREATE DATABASE IF NOT EXISTS sql_test";
    //Ejecutamos la sentencia
    //Retorna TRUE si ha tenido éxito la ejecución
    //Retorna FALSE si ha fracasado en la ejecición
    $conn->exec($sql);

    //Crear una tabla
    try {
        // sql to create table
        $sql = "CREATE TABLE IF NOT EXISTS MyGuests (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL,
            email VARCHAR(50),
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        // ejecutamos la conexión
        $conn->exec($sql);
        //Lanzamos mensaje de confirmación
        echo "<br>Table MyGuests created successfully";
    } catch(PDOException $e) {
        echo "<br>".$sql . "<br>" . $e->getMessage();
    }

    //Insertar un registro en la tabla
    try {
        //Sentencia sql
        $sql = "INSERT INTO MyGuests (firstname, lastname, email)
        VALUES ('John', 'Doe', 'john@example.com')";
        // Ejecutamos la consulta
        $conn->exec($sql);
        //Mensaje de confirmación
        echo "<br>New record created successfully";
    } catch(PDOException $e) {
        echo "<br>".$sql . "<br>" . $e->getMessage();
    }

    //Obtener el último id insertado en la tabla
    try {
        //Sentencia sql
        $sql = "INSERT INTO MyGuests (firstname, lastname, email)
        VALUES ('John', 'Doe', 'john@example.com')";
        // Ejecutamos la sentencia
        $conn->exec($sql);
        //Obtenemos el último id
        $last_id = $conn->lastInsertId();
        echo "<br>New record created successfully. Last inserted ID is: " . $last_id;
    } catch(PDOException $e) {
        echo "<br>".$sql . "<br>" . $e->getMessage();
    }

    //Inserciones múltiples
    try {
        // Comenzar la transacción
        $conn->beginTransaction();
        // Ejecutamos las consultas insert
        $conn->exec("INSERT INTO MyGuests (firstname, lastname, email)
        VALUES ('John', 'Doe', 'john@example.com')");
        $conn->exec("INSERT INTO MyGuests (firstname, lastname, email)
        VALUES ('Mary', 'Moe', 'mary@example.com')");
        $conn->exec("INSERT INTO MyGuests (firstname, lastname, email)
        VALUES ('Julie', 'Dooley', 'julie@example.com')");
        // commit. Indicar al sql que persista los datos
        $conn->commit();
        //Mensaje de confirmación
        echo "<br>New records created successfully";
    } catch(PDOException $e) {
        // Durante el conjunto de sentencias sql, ha habido algún fallo
        //en alguna de ellas, realizando un rollback() las deshace
        $conn->rollback();
        //Mensaje de error
        echo "<br>Error: " . $e->getMessage();
    }

    //Preparación de sentencias
    try {
        // Preparar SQL y vincular parámetros
        $stmt = $conn->prepare("INSERT INTO MyGuests (firstname, lastname, email)
        VALUES (:firstname, :lastname, :email)");
        //Asignamos las variables que usaremos en la sentencia preparada
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);

        // Ejecutamos la sentencia preparada
        //Definimos el valor de cada variable
        $firstname = "John";
        $lastname = "Doe";
        $email = "john@example.com";
        $stmt->execute();

        // Si quiero ejecutar de nuevo la sentencia
        //Sólo debo cambiar los valores de las variables y ejecutar
        $firstname = "Mary";
        $lastname = "Moe";
        $email = "mary@example.com";
        $stmt->execute();

        // Otra ejecución
        $firstname = "Julie";
        $lastname = "Dooley";
        $email = "julie@example.com";
        $stmt->execute();

        //Mensaje de confirmación
        echo "<br>New records created successfully";
        } catch(PDOException $e) {
            //Mensaje de error
            echo "<br>Error: " . $e->getMessage();
        }

    //Sentencias SELECT
    try {
        //Sentencia sql preparada
        $stmt = $conn->prepare("SELECT id, firstname, lastname FROM MyGuests");
        //Ejecuto la sentencia preparada
        $stmt->execute();

        // Ejecuta la sentencia preparada y devuelve un array asociativo
        //Será TRUE/FALSE en función del éxito de la operación
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        //Le indicamos que nos devuelva todos los resultados en un array asociativo
        $users = $stmt->fetchAll();
        //Recorremos el array asociativo y mostramos los resultados
        echo "<br>LA TABLA CONTIENE:";
        echo "<br>==================";
        foreach($users as $item) {
            echo "<br>ID: ".$item["id"]." | Nombre: ".$item["firstname"].
            " | Apellidos: ".$item["lastname"];
        }
    } catch(PDOException $e) {
        //Mensaje de error
        echo "Error: " . $e->getMessage();
    }

    //Uso de cláusula WHERE
    try {
        //Preparamos la sentencia
        $stmt = $conn->prepare("SELECT id, firstname, lastname FROM MyGuests WHERE id=1");
        $stmt->execute(); //Ejecutamos la sentencia preparada

        // Indicamos que queremos array asociativo
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        //Nos devuelve un array asociativo de una un sólo elemento
        $user = $stmt->fetchAll();
        //Imprimir salida -> NO es necesario hacer foreach xk en este ejemplo
        //Sólo existirá un elemento en el array
        echo "<br>Los datos del usuario son<br>ID: ".$user[0]["id"].
        " <br>Nombre: ".$user[0]["firstname"].
        " <br>Apellidos: ".$user[0]["lastname"];
    }
    catch(PDOException $e) {
        //Mensaje de error
        echo "<br>Error: " . $e->getMessage();
    }

    //Eliminar un registro
    try {
        // Sentencia SQL
        $sql = "DELETE FROM MyGuests WHERE id=3";
        // Ejecutamos la sentencia
        $conn->exec($sql);
        //Mensaje de confirmación
        echo "<br>Record deleted successfully";
    } catch(PDOException $e) {
        //Mensaje de error
        echo "<br>".$sql . "<br>" . $e->getMessage();
    }

    //Actualizar un registro
    try {
        //Sentencia SQL
        $sql = "UPDATE MyGuests SET lastname='XXX' WHERE id=2";
        // Preparamos la sentencia
        $stmt = $conn->prepare($sql);
        //Ejecutamos la sentencia preparada
        $stmt->execute();
        //Mensaje de confirmación
        echo "<br>".$stmt->rowCount() . " records UPDATED successfully";
    } catch(PDOException $e) {
        //Mensaje de error
        echo "<br>".$sql . "<br>" . $e->getMessage();
    }
?>