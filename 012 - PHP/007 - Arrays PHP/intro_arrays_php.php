<?php
# http://localhost/repo/unitel-RubenUnitel/012%20-%20PHP/007%20-%20Arrays%20PHP/intro_arrays_php.php

//Declaración + Inicialización
//Índices
$cars = array("Volvo", "BMW", "Toyota");

//Asociativo
$numeros = array("Uno" => 1, "Dos" => 2, "Tres" => 3);

//Contar (devuelve el número de elementos del array)
echo "El array cars contiene: ".count($cars)." elementos<br>";

//Acceder a una posición en array indexados
echo "Imprimir posición 1: ".$cars[1]."<br>";

//Cambiar valores del array
$cars[1] = "Ford";
echo "Imprimir posición 1: ".$cars[1]."<br>";

//Recorrer un array
foreach ($cars as $item) {
  echo "$item <br>";
}
//Alternativa
for ($i=0; $i < count($cars); $i++) { 
    echo "$cars[$i] <br>";
}

//Añadir un elemento al final del array
array_push($cars, "Ford");
var_dump($cars);
echo "<br>";
//Alternativa
$cars[count($cars) + 1] = "Ford";
var_dump($cars);
echo "<br>";
//Alternativa
$fruits = array("Apple", "Banana", "Cherry");
$fruits[] = "Orange";

//Array con indexación no consecutiva
$cars[5] = "Volvo";
$cars[7] = "BMW";
$cars[14] = "Toyota";
//Sólo se puede recorrer con foreach o reordenar el índice (función)
function reordenarIndex(array $array) : array {
    $array_temp = array();
    foreach ($array as $key => $valor)
    {
        $array_temp[] = $valor;
    }
    return $array_temp;
}
echo "ARRAY REORDENADO<br>";
$cars_ordenado = reordenarIndex($cars);
var_dump($cars_ordenado);

//Array asociativo
$car = array("brand"=>"Ford", "model"=>"Mustang", "year"=>1964);

//Acceder a una posición de un array asociativo
echo "<br>El modelo es: ".$car["model"];

//Modificar un valor del array asociativo
$car["year"] = 2024;
var_dump($car);

//Recorrer array asociativo
echo "<br>";
foreach ($car as $key => $valor) {
  echo "$key: $valor <br>";
  //Alternativa
  //echo $car[$key];
}

//Creación de arrays
$cars = array("Volvo", "BMW", "Toyota");
$cars = ["Volvo", "BMW", "Toyota"];
$cars = [
  "Volvo",
  "BMW",
  "Toyota"
];
$cars = [
  "Volvo",
  "BMW",
  "Toyota",
];
$cars = [
  0 => "Volvo",
  1 => "BMW",
  2 => "Toyota"
];
$myCar = [
  "brand" => "Ford",
  "model" => "Mustang",
  "year" => 1964
];
$cars = array(); //Array vacío
$cars = []; //Array vacío

//Funciones dentro de arrays
function myFunction() {
  echo "I come from a function!<br>";
}

$myArr = array("Volvo", 15, myFunction());

//Llamada a la función dentro del array
$myArr[2];

//Modificar un array desde un bucle
$cars = array("Volvo", "BMW", "Toyota");
foreach ($cars as &$item) {
  $item = "Ford";
}
var_dump($cars);

//Eliminar un elemento del array
echo "<br>";
unset($cars[1]);
var_dump($cars);

//Añadir múltiples elementos índices
$fruits = array("Apple", "Banana", "Cherry");
array_push($fruits, "Orange", "Kiwi", "Lemon");
echo "<br>";
var_dump($fruits);

//Añadir múltiples elementos en asociativo
$cars = array("brand" => "Ford", "model" => "Mustang");
$cars += ["color" => "red", "year" => 1964];

//Eliminar múltiples elementos
$cars = array("Volvo", "BMW", "Toyota");
echo "<br>Array original:";
var_dump($cars);
echo "<br>Array modificado:";
array_splice($cars, 1, 1);
echo "<br>";
var_dump($cars);

//Diferencias en arrays
echo "<br>Diferencias arrays:<br>";
$cars1 = array("brand" => "Ford", "model" => "Mustang", "year" => 1964);
$cars2 = ["Mustang", 1964];
$newarray = array_diff($cars1, $cars2);
var_dump($newarray);

//Eliminar último elemento
$cars = array("Volvo", "BMW", "Toyota");
array_pop($cars);

//Eliminar el primer elemento
$cars = array("Volvo", "BMW", "Toyota");
array_shift($cars);

//Ordenar arrays
/**
 * sort() - sort arrays in ascending order
 * rsort() - sort arrays in descending order
 * asort() - sort associative arrays in ascending order, according to the value
 * ksort() - sort associative arrays in ascending order, according to the key
 * arsort() - sort associative arrays in descending order, according to the value
 * krsort() - sort associative arrays in descending order, according to the key
 */
echo "<br>Ordenar array:<br>";
$cars = array("Volvo", "BMW", "Toyota");
sort($cars);
var_dump($cars);

//Dimensión de arrays
//Unidimensional
$cars = array("Volvo", "BMW", "Toyota");

//Bidimensionales
$cars = array (
  array("Volvo",22,18),
  array("BMW",15,13),
  array("Saab",5,2),
  array("Land Rover",17,15)
);

//Acceso al bidimensional
echo "<br><br>";
echo $cars[0][0].": In stock: ".$cars[0][1].", sold: ".$cars[0][2].".<br>";
echo $cars[1][0].": In stock: ".$cars[1][1].", sold: ".$cars[1][2].".<br>";
echo $cars[2][0].": In stock: ".$cars[2][1].", sold: ".$cars[2][2].".<br>";
echo $cars[3][0].": In stock: ".$cars[3][1].", sold: ".$cars[3][2].".<br>";

//Recorrer bidimensional
echo "<br>RECORRER BIDIMENSIONAL:<br>";
foreach ($cars as $car)
{
    foreach ($car as $key => $value)   
    {
    echo "$key:$value<br>";
    }
}
//Alternativa
echo "<br>RECORRER BIDIMENSIONAL ALTER:<br>";
for ($i=0; $i < count($cars); $i++)
{ 
    for ($j=0; $j < count($cars[$i]); $j++)
    { 
        echo $cars[$i][$j]."<br>";
    }
}

//Funciones
// array_combine() -> Combinación de arrays
// array_diff() -> Encuentra las diferencias entre arrays
// array_fill() -> Rellena un array
// array_keys() -> Devuelve las llaves del array asociativo
// array_merge() -> Une varios arrays en uno
// array_rand() -> Crea un array aleatorio
// array_replace() -> Reemplaza valores
// array_reverse() -> Invierte el orden de un array
// array_search() -> Busca ocurrencias dentro de un array
// array_unique() -> Elimina valores duplicados
// count() -> Cuenta los elementos de un array
// key() -> Devuelve la llave de un array
// shuffle() -> Mezcla un array

$array = array(
    "Pregunta 1",
    "Pregunta 2",
    "Pregunta 3",
    "Pregunta 4",
    "Pregunta 5",
    "Pregunta 6"
);
echo "<br>SHUFFLE<br>";
shuffle($array);
foreach ($array as $key => $value)
{
    echo $value."<br>";
}
