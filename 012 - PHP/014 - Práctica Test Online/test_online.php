<?php
# http://localhost/repo/unitel-RubenUnitel/012%20-%20PHP/012%20-%20Pr%C3%A1ctica%20Test%20Online/test_online.php

//Incluyo la clase "pregunta"
require "clases/pregunta.php";

//Instancio una pregunta de prueba
/*for ($i=0; $i < 10; $i++) { 
    $pregunta = new pregunta(
        null,
        "¿Esta es mi pregunta? $i",
        array(
            "Respuesta 1",
            "Respuesta 2",
            "Respuesta 3",
            "Respuesta 4"
        ),
        1
    );
    //La guardo y compruebo el archivo
    $pregunta->save();
}*/

//Probar a instanciar una pregunta según su id
$pregunta = new pregunta(2);
var_dump($pregunta->id_pregunta);
var_dump($pregunta->pregunta);

//Probar a instanciar una pregunta que no exista
/*$pregunta = new pregunta(100);
var_dump($pregunta->id_pregunta);
var_dump($pregunta->pregunta);*/


//if (! session_start()) die("OMG, total session asplosion.");
/*session_start();
$_SESSION["var1"] = "mi texto de la variable";*/
//header("Location: test.php");