<?php

// Incluyo la clase "pregunta"
require "Clases/pregunta.php";

// Crear 20 preguntas de prueba
for ($i = 0; $i < 20; $i++) {
    // Instancio una pregunta de prueba
    $pregunta = new Pregunta(
        null,
        "¿Esta es mi pregunta?".$i,
        array(
            "Respuesta 1",
            "Respuesta 2",
            "Respuesta 3",
            "Respuesta 4"
        ),
        1
    );

    // Guardo la pregunta
    $pregunta->save();
}
