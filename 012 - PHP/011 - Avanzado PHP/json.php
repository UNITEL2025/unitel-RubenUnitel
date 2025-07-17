<?php

//JSON
//Forma de guardar datos
//Habitualmente se usa para arrays
//Convierte el dato "complejo" de php, es una cadena string estructurada

/**
 * EJEMPLO
 * $array = array(0 => "Texto 0", 1 => "Texto 1");
 * JSON = {"0":"Texto 0", "1":"Texto 1"}
 */

/**
 * VENTAJAS:
 * Permite guardar como texto plano variables completas:
 * cookie, session, sql, txt, ...
 * Se convierte muy fácil: de JSON a Tipo de Dato (array, objecto, etc...)
 * y viceversa
 */

//Ejemplo: De array asociativo a JSON
$age = array("Peter"=>35, "Ben"=>37, "Joe"=>43);

echo json_encode($age);
echo "<br>";

//Ejemplo: De array de índices a JSON
$cars = array("Volvo", "BMW", "Toyota");

echo json_encode($cars);

//Ejemplo: De JSON a objeto
echo "<br>";
$jsonobj = '{"Peter":35,"Ben":37,"Joe":43}';

var_dump(json_decode($jsonobj));

//Ejemplo: De JSON a array asociativo
echo "<br>";
$jsonobj = '{"Peter":35,"Ben":37,"Joe":43}';

var_dump((array) json_decode($jsonobj));

//Alternativa a la anterior
echo "<br>";
$jsonobj = '{"Peter":35,"Ben":37,"Joe":43}';

var_dump(json_decode($jsonobj, true));

//Acceso a los valores JSON
$jsonobj = '{"Peter":35,"Ben":37,"Joe":43}';

$obj = json_decode($jsonobj);

//Impresión de valores desde objeto
echo "<br>".$obj->Peter;
echo "<br>".$obj->Ben;
echo "<br>".$obj->Joe;

//Impresión de valores desde array
$jsonobj = '{"Peter":35,"Ben":37,"Joe":43}';

$arr = json_decode($jsonobj, true);

echo "<br>".$arr["Peter"];
echo "<br>".$arr["Ben"];
echo "<br>".$arr["Joe"];

//Recorrer los valores de un objeto (igual que un array)
$jsonobj = '{"Peter":35,"Ben":37,"Joe":43}';

$obj = json_decode($jsonobj);

foreach($obj as $key => $value) {
  echo "<br>".$key . " => " . $value;
}