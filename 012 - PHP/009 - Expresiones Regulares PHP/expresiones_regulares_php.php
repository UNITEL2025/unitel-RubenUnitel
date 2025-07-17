<?php
# http://localhost/repo/unitel-RubenUnitel/012%20-%20PHP/009%20-%20Expresiones%20Regulares%20PHP/expresiones_regulares_php.php

//EXPRESIONES REGULARES

//Indica si existe la ocurrencia una palabra en un string
$str = "Visit W3Schools"; //Texto donde buscar
$pattern = "/w3schools/i"; //Patrón a buscar (buscar el texto sin diferenciar mayús y minús)
echo preg_match($pattern, $str);
echo "<br>";

//Cuenta el número de ocurrencias en el string
$str = "The rain in SPAIN falls mainly on the plains.";
$pattern = "/ain/i";
echo preg_match_all($pattern, $str);
echo "<br>";

//Reemplaza string
$str = "Visit Microsoft!";
$pattern = "/microsoft/i";
echo preg_replace($pattern, "W3Schools", $str);
echo "<br>";