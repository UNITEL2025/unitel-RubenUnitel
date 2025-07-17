<?php

//1. Confirmamos el método de envío del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    //2. Obtener las variables
    $data = array(
        "name" => $_POST["name"],
        "email" => $_POST["email"],
        "pass" => $_POST["pswd"],
        "remember" => (isset($_POST["remember"])) ? true:false, //3. Ajustamos remember: false => No existe; true = "on"
        "comment" => $_POST["comment"],
        "option1" => (isset($_POST["option1"])) ? true:false,
        "option2" => (isset($_POST["option2"])) ? true:false,
        "estado" => $_POST["estado"]
    );
    //ALTERNATIVA 3.
    // if (isset($_POST["remember"]))
    // {
    //     $data["remember"] = true;
    // }
    //4. Redireccionar a otra página
    header("Location: validar.html");
}
