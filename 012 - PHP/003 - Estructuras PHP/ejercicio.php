<?php
# http://localhost/repo/unitel-RubenUnitel/012%20-%20PHP/003%20-%20Estructuras%20PHP/ejercicio.php

/**
 * ESTRUCTURAS DE CONTROL
 */

//Condicionales
//Condicional 1
// Si se cumple la condición se ejecuta el bloque de código interno
//if (condition) {
  // code to be executed if condition is true;
//}

$var1 = 10;
$var2 = 20;
$var3 = 10;
//Diferentes formas de tabular el IF
//Forma 1
if ($var1 == $var2) echo "$var1 y la $var2: Son iguales";
if ($var1 == $var3) echo "$var1 y la $var3: Son iguales";

//Forma 2
// if ($var1 == $var2)
//     echo "Son iguales";
// echo "Esta sentencia no forma parte del if"

//Forma 3
// if ($var1 == $var2)
// {
//     echo "Son iguales";
// }

//Condicional 2
//Se pueden realizar dobles comparaciones
$a = 200;
$b = 33;
$c = 500;
//Condición: true AND true => true
if ($a > $b && $a < $c ) {
  echo "<br>Both conditions are true";
}

//Ejemplo de comprobar edad (ejercicio de linux)
$edad = null;
if ($edad != null && $edad > 18)
{
    echo "<br>Eres mayor de edad.";
}

//Ejemplo
$a = 7;

if ($a == 2 || $a == 3 || $a == 4 || $a == 5 || $a == 6 || $a == 7) {
  echo "<br>$a is a number between 2 and 7";
}

//Versión compacta
if ($a >= 2 && $a <= 7) {
    echo "<br>$a is a number between 2 and 7";
}

//Condicional 3
//IF...ELSE
// if (condition) {
//   // code to be executed if condition is true;
// } else {
//   // code to be executed if condition is false;
// }
//Si se cumple la condición, se ejecuta el bloque IF,
//en caso contrario, ejecuta el bloque ELSE
$t = date("H");

if ($t < "20") {
  echo "<br>Have a good day!";
} else {
  echo "<br>Have a good night!";
}

//Condicional 4
//IF...ELSEIF...ELSE
// if (condition) {
//   code to be executed if this condition is true;
// } elseif (condition) {
//   // code to be executed if first condition is false and this condition is true;
// } else {
//   // code to be executed if all conditions are false;
// }
$t = date("H");

if ($t < "10") {
  echo "<br>Have a good morning!";
} elseif ($t < "20") {
  echo "<br>Have a good day!";
} else {
  echo "<br>Have a good night!";
}

//Condicional 5
//IF Anidados
$a = 30;
$salida = "<br>No ha entrado en el IF";

if ($a > 10) {
  $salida = "<br>Above 10";
  if ($a > 20) {
    $salida .= " and also above 20";
  } else {
    $salida .= " but not above 20";
  }
}
echo $salida;

//Switchs
// switch (expression) {
//   case label1:
//     //code block
//     break;
//   case label2:
//     //code block;
//     break;
//   case label3:
//     //code block
//     break;
//   default:
//     //code block
// }

//Ejemplo
$favcolor = "red";

switch ($favcolor) {
  case "red":
    echo "<br>Your favorite color is red!";
    break;
  case "blue":
    echo "<br>Your favorite color is blue!";
    break;
  case "green":
    echo "<br>Your favorite color is green!";
    break;
  default:
    echo "<br>Your favorite color is neither red, blue, nor green!";
}

//Loops (bucles)
//Bucle 1
// while (expresion) {
//   Code...
// }

$i = 1;
while ($i <= 6) {
  echo "<br>Estamos en la iteración: ".$i;
  $i++;
}

//Bucle 2
//Forzar la salida del bucle aunque se cumpla la condición
$i = 1;
while ($i < 6) {
  if ($i == 3) break;
  echo "<br>Iteración bucle con salida forzada: ".$i;
  $i++;
}

//Bucle 3
//Forzar la continuidad del boque
$i = 0;
while ($i < 6) {
  $i++;
  if ($i == 3) continue;
  echo "<br>Iteración bucle con continuación forzada: ".$i;
}

//Bucle 4
//DO...WHILE
$i = 1;

do {
  echo "<br>Iteración do while: ".$i;
  $i++;
} while ($i < 6);

//Ejemplo sin cumplir la condición
$i = 8;

do {
  echo "<br>Iteración do while (no cumple condición): ".$i;
  $i++;
} while ($i < 6);

//FOR
//For 1
// for (expression1, expression2, expression3) {
//   // code block
// }
for ($x = 0; $x <= 10; $x++) {
  echo "<br>The number is: $x";
}

//Ejemplo con array
$array = array("Rojo", "Azul", "Verde", "Naranja", "Blanco");
for ($x = 0; $x < 5; $x++)
{
  echo "<br>El valor del array en la posición $x es: $array[$x]";
}

//Ejemplo con array y break
$array = array("Rojo", "Azul", "Verde", "Naranja", "Blanco");
for ($x = 0; $x < 5; $x++)
{
  echo "<br>El valor del array con break en la posición $x es: $array[$x]";
  if ($array[$x] == "Verde") break;
}

//Ejemplo con array (impresión al revés)
$array = array("Rojo", "Azul", "Verde", "Naranja", "Blanco");
for ($x = 4; $x >= 0; $x--)
{
  echo "<br>El valor del array (invertido) en la posición $x es: $array[$x]";
}

//For 2
//Foreach
$colors = array("red", "green", "blue", "yellow");

foreach ($colors as $color) {
  echo "<br>Foreach: El valor del array es: $color";
}

//Ejemplo añadiendo contador
$colors = array("red", "green", "blue", "yellow");
$i = 0;

foreach ($colors as $color) {
  echo "<br>Foreach: El valor del array en la pos $i es: $color";
  $i++;
}

//For 3
//Foreach
$members = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");
//Peter => Key
//35 => Value

foreach ($members as $key => $value) {
  echo "<br>Foreach Asociativo. Para la llave $key, el valor es: $value";
}

//Ejemplo BBDD
$usuarios = array(
  array("id" => 0, "name" => "Peter", "age" => 35),
  array("id" => 1, "name" => "Ben", "age" => 37),
  array("id" => 2, "name" => "Joe", "age" => 43)
);

foreach ($usuarios as $user) {
  echo "<br>El usuario ".$user["name"]." tiene un id: ".$user["id"]." y su edad es ".$user["age"];
}

//Ejemplo con objetos
class Car {
  public $color;
  public $model;
  public function __construct($color, $model) {
    $this->color = $color;
    $this->model = $model;
  }
}

$myCar1 = new Car("red", "Volvo");
$myCar2 = new Car("blue", "Renault");
$myCar3 = new Car("green", "Citroen");

$coches = array($myCar1, $myCar2, $myCar3);

echo "<br>";
echo "<br>LISTADO DE COCHES";
echo "<br>=================";
foreach ($coches as $coche) {
  echo "<br>Color de coche $coche->color y su modelo es $coche->model";
}

//No se pueden modificar datos dentro del bucle
$colors = array("red", "green", "blue", "yellow");

foreach ($colors as $x) {
  if ($x == "blue") $x = "pink";
}

echo "<br>";
var_dump($colors);

//Como modificar datos del array dentro del bucle
$colors = array("red", "green", "blue", "yellow");

foreach ($colors as &$x) {
  if ($x == "blue") $x = "pink";
}

echo "<br>";
var_dump($colors);