<?php
// http://localhost/Repositorio/unitel2025-belengarciar/PHP/013_Php/test_online.php

// Incluyo la clase "pregunta"
require "Clases/pregunta.php";

// Instancio una pregunta de prueba
$pregunta = new Pregunta (
    1,
    "¿Esta es mi pregunta?",
    array(
        "Respuesta 1",
        "Respuesta 2",
        "Respuesta 3",
        "Respuesta 4"
    ),
    1
);

// La guardo y compruebo el archivo
//$pregunta->save();

$pregunta->getlastId();