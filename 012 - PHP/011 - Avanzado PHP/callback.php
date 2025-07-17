<?php

//CALLBACK
//Son funciones que pasan argumentos a otra función
//Tb puede ser que se pasen argumentos a sí mismas (función recursiva)

// La función recibe un string y devuelve la longtitud del mismo
function my_callback($item) {
  return strlen($item);
}
//Definimos un array de strings
$strings = ["apple", "orange", "banana", "coconut"];

//Opción 1: Copiar y pegar
// $len_0 = strlen($strings[0]);
// $len_1 = strlen($strings[1]);
// $len_2 = strlen($strings[2]);
// $len_3 = strlen($strings[3]);

//Opción2: Hacer un for
// $resultado = array();
// for ($i = 0; $i < count($strings); $i++)
// {
//     $resultado[] = strlen($strings[$i]);
// }
//Opción 3: Con callback
$lengths = array_map("my_callback", $strings);
//Imprimimos resultado
print_r($lengths);

//Alternativa: Embebiendo la función en el argumento
//Mismo que lo anterior
$strings = ["apple", "orange", "banana", "coconut"];
$lengths = array_map(
    //Param1: Función como parámetro dentro del argumento
    function($item) {
        return strlen($item);
    } ,
    //Param 2: Array
    $strings
);
print_r($lengths);

//Callback con funciones personalizadas por el usuario
//Función estándar que añade al str un signo de exclamación
function exclaim($str) {
  return $str . "! ";
}
//Función estándar que añade al str un signo de integorración
function ask($str) {
  return $str . "? ";
}
//Función que llama a las dos anteriores
//$format => Nombre de la función definida previamente
function printFormatted($str, $format) {
  echo "<br>".$format($str);
}
// Param 1: Se le pasa la cadena de texto
// Param 2: Se le pasa la función que queremos llamar
printFormatted("Hello world", "exclaim");
printFormatted("Hello world", "ask");