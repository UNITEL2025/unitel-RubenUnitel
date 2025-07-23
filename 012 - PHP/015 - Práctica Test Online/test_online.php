<?php
# http://localhost/repo/unitel-RubenUnitel/012%20-%20PHP/012%20-%20Pr%C3%A1ctica%20Test%20Online/test_online.php

//Incluyo la clase "pregunta"
require "clases/pregunta.php";

/*$pregunta = new pregunta();
$pregunta = $pregunta->deleteAll();*/

//Instancio una pregunta de prueba
for ($i=0; $i < 10; $i++) { 
    $pregunta = new pregunta(
        null,
        "¿Esta es mi pregunta? $i",
        array(
            "Respuesta 1 de P$i",
            "Respuesta 2 de P$i",
            "Respuesta 3 de P$i",
            "Respuesta 4  de P$i"
        ),
        1
    );
    //La guardo y compruebo el archivo
    $pregunta->save();
}
/*$pregunta = new pregunta();
$pregunta = $pregunta->getAll();*/

//Actualizar una pregunta
/*$pregunta = new pregunta();
$pregunta = $pregunta->getById(3);
echo "<br><br>VIEJA:<br>";
var_dump($pregunta->pregunta);
$pregunta->pregunta = "Título modificado";
$pregunta->save();
echo "<br><br>NUEVA:<br>";
var_dump($pregunta->pregunta);*/

//Eliminar todas las preguntas
/*$pregunta = new pregunta();
$pregunta = $pregunta->deleteAll();*/

//Probar a instanciar una pregunta que no exista
/*$pregunta = new pregunta(100);
var_dump($pregunta->id_pregunta);
var_dump($pregunta->pregunta);*/


//if (! session_start()) die("OMG, total session asplosion.");
/*session_start();
$_SESSION["var1"] = "mi texto de la variable";*/
//header("Location: test.php");