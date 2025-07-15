<?php
# http://localhost/repo/unitel-RubenUnitel/012%20-%20PHP/004%20-%20Funciones%20PHP/funciones_php.php

//FUNCIONES
//Crear una función
function myMessage() {
  echo "<br>Hello world!";
}

myMessage();
myMessage();
myMessage();

//Argumentos/Parámetros/Params/Inputs
function familyName($fname) {
  echo "<br>El nombre es: $fname";
}

familyName("Jani");
familyName("Hege");
familyName("Stale");
familyName("Kai Jim");
familyName("Borge");

//Se pueden pasar varios inputs (hasta N)
function familyName2($fname, $year) {
  echo "<br>$fname Refsnes. Born in $year";
}

familyName2("Hege", "1975");
familyName2("Stale", "1978");
familyName2("Kai Jim", "1983");

//Argumentos por defecto (opcionales)
function setHeight($minheight = 50) {
  echo "<br>The height is : $minheight";
}

setHeight(350);
setHeight(); // will use the default value of 50
setHeight(135);
setHeight(80);

//Retorno de de valores (output)
//Puede retornar cualquier tipo de dato
function sum($valor1, $valor2) {
  $suma = $valor1 + $valor2;
  return $suma;
}

echo "<br>5 + 10 = " . sum(5, 10);
echo "<br>7 + 13 = " . sum(7, 13);
echo "<br>2 + 4 = " . sum(2, 4);

//Retornar varios valores
function sum2($valor1, $valor2) {
  $suma = $valor1 + $valor2;
  //Retorno con array asociativo
  return array("valor1" => $valor1, "valor2" => $valor2, "resultado" => $suma);
  //Retorno con array de índices
  //return array($valor1, $valor2, $suma);
}

//Ventaja: sólo se llama a la función 1 sóla vez
$salida = sum2(5, 10); //$salida será un array
echo "<br>".$salida["valor1"]." + ".$salida["valor2"]." = ".$salida["resultado"];
//Desventaja: Se llama a la función 3 veces
echo "<br>".sum2(7, 13)["valor1"]." + ".sum2(7, 13)["valor2"]." = ".sum2(7, 13)["resultado"];

//Argumentos referenciados
function add_five(&$value) {
  $value += 5;
}

$num = 2;
add_five($num);
echo "<br>El valor del argumento por referencia es: ".$num;

//Funciones variadas
//Buenas Práctica => Pasar un array con longitud indeterminada
//El param de input, se convierte en un array de índices
function sumMyNumbers(...$numeros) {
  $suma = 0;

  //Opción 1
  //$len es la longitud del array (número de elementos que contiene)
  //$len = count($numeros); //$len valdrá 6
  //$i es el contador
  // for($i = 0; $i < $len; $i++) {
  //   $suma += $numeros[$i];
  // }

  //Opción 2
  foreach ($numeros as $numero)
    $suma += $numero;
  return $suma;
}

$a = sumMyNumbers(5, 2, 6, 2, 7, 7);
echo "<br>La suma de los números es: ".$a;

//Declaración de tipo de datos de input y output
function sum3(float $a, float $b) : float {
  return $a + $b;
}
echo "<br>La suma de los números es: ".sum3(5, 7);