<?php
# http://localhost/repo/unitel-RubenUnitel/012%20-%20PHP/006%20-%20Pr%C3%A1ctica%20Funciones%20PHP/ejercicios_php_funciones.php

// ===============================
// EJERCICIOS DE FUNCIONES EN PHP
// ===============================

// 1. Crea una función que reciba un nombre como parámetro y devuelva un saludo:
// "Hola, [nombre]".
function welcome(string $name = "") : void {
    if ($name == "")
        echo "Hola, desconocido!<br>";
    else
        echo "Hola, $name!<br>";
}
welcome();
welcome("Rubén");

// 2. Crea una función que imprima las tablas de multiplicar del 1 al 9.
function tablas() {
    echo "TABLAS DE MULTIPLICAR<br>";
    echo "=====================<br>";
    echo "<br>";
    for ($i = 1; $i <= 9; $i++)
    {
        echo "#####################<br>";
        echo "#######TABLA $i######<br>";
        echo "#####################<br>";
        for ($j = 1; $j <= 10; $j++)
        {
            echo "$i X $j = ".$i*$j."<br>";
        }
    }
}
tablas();

// 3. Crea una función que calcule el factorial de un número.
function factorial(float $num) : void {
    $resultado = 1;
    for ($i = 1; $i <= $num; $i++)
    {
        $resultado *= $i;
    }
    echo "El factorial de $num es: $resultado<br>";
}
factorial(5); //Resultado: 120

// 4. Crea una función para calcular el área de un rectángulo.
function calcularArea(float $base, float $altura) : string {
    return "El área del rectángulo es ".$base * $altura;
}

echo calcularArea(20, 15)."<br>";

// 5. Crea una función que convierta grados Celsius a Fahrenheit.
function conversor(float $celsius) : float {
    return ($celsius * 9 / 5) + 32;
}

echo "50 grados Celsius son ".conversor(50)." grados Fahrenheit.<br>";

// 6. Crea una función que reciba un array de números y devuelva el promedio.
function promedio(array $input) : float {
    $suma = 0;
    foreach ($input as $key => $value) {
        $suma += $value;
    }
    return $suma / count($input);
}

echo "El promedio de: 5, 8, 14, 22 y 56 es: ".promedio(array(5, 8, 14, 22, 56))."<br>";

// 7. Crea una función que determine si un string es un palíndromo
// (se lee igual al derecho y al revés).
function check(string $str) : bool {
    //1. Pasamos a minúsculas
    $str = strtolower($str);
    //2. Limpiamos el string eliminando espacios
    $str_clear = str_replace(" ", "", $str);
    //3. Sustituimos vocales con acentos
    $sustitucion = array(
        "á" => "a",
        "é" => "e",
        "í" => "i",
        "ó" => "o",
        "ú" => "u",
        "." => "",
        "," => "",
        ";" => "",
        ":" => "",
        "!" => "",
        "¡" => "",
        "?" => "",
        "¿" => "",
        "@" => ""
    );
    foreach ($sustitucion as $key => $valor) {
        $str_clear = str_replace($key, $valor, $str_clear);
    }

    //4. Comprobamos si son iguales
    if ($str_clear == strrev($str_clear)) return true;
    else return false;
}

$frase = "Dábale arroz a la zorra el abad.";
if (check($frase) == true) {
    echo "La frase es un palíndromo<br>";
}
else {
    echo "La frase NO es un palíndromo<br>";
}
// 8. Crea una función que reciba un array de nombres y los imprima en una lista numerada.
$nombres = array("Pepe", "María", "Silvia", "Sergio", "Iván");

function printNames(array $nombres) : void {
    for ($i = 0; $i < count($nombres); $i++) {
        echo ($i+1).") ".$nombres[$i]."<br>";
    }
    //Alternativa
    /*for ($i = 1; $i <= count($nombres); $i++) {
        echo $i.") ".$nombres[$i - 1]."<br>";
    }*/
}

printNames($nombres);

// 9. Crea una función con un parámetro opcional. Si no se pasa valor, debe usar un valor
// por defecto. Debe imprimir el valor.
function get(string $str = "Sin valor") : void {
    echo "El valor del param es: ".$str."<br>";
}
get("CASA");
get();

// 10. Crea una función recursiva que imprima un intervalo de números según
// indique el usuario.
function recursiva(int $min, int $max) : void {
    //1. Comprobar que el mínimo < máximo
    if ($min >= $max)
    {
        echo "El máx no puede ser menor o igual al mín<br>";
    }
    else {
        for ($i=$min; $i <= $max ; $i++) { 
            echo "Recursivo: ".$i."<br>";
        }
    }
}

recursiva(5, 10);

