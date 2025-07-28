<?php

require_once ("file.php");
require_once ("preguntas.php");

//TESTEO DE LA CLASE FILE.PHP
$filename = "test.txt";
//1) Escribir cuando el archivo no existe
$datos = array(
    "Cadena str 1",
    "Cadena str 2"
);
//file::escribirArc($filename, $datos); //Escribe en modo w
//2) Añadir contenido al archivo ya creado
//file::escribirArc($filename, $datos); //Escribe en modo a
//3) Recuperar contenido
//var_dump(file::leerArc($filename));
//4) Comprobar borrado de contenido
file::eliminarArch($filename);
die('fin');


//NO instanciamos la clase
$test = new file ("preguntas.txt");

//$test->estadoArc(); -- Funciona

//$test->escribirArc("Hola Mundo");

//$test->leerArc();

//$test->eliminarArch();

$pregunta1 = new pregunta (
    1,
    "¿De que color es el caballo blanco de Santiago?",
    ["Negro","Blanco","Marron","¿Quien es ese?"],
    0
);

$pregunta2 = new pregunta (
    2,
    "¿Cuanto es 2 x 2?",
    [0,22,"No se, suspendi matematicas",4],
    3
);

$archivo = new file ("preguntas.txt");

$archivo->save($pregunta1);
$archivo->save($pregunta2);