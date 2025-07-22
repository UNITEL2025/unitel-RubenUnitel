<?php

//Definimos variables del script
$seguridad;
$pass = "";
$lmayus = "QWERTYUIOPASDFGHJKLZXCVBNM";
$lminus = "qwertyuiopasdfghjklzxcvbnm";
$symbols = "@#$%&/()[]{}";

//Obtenemos variables de $_POST
if (isset($_POST["seguridad"]))
{
    $seguridad = $_POST["seguridad"];

    //Generamos la contraseña
    switch ($seguridad)
    {
        //Contraseña de 4 dígitos
        case "BAJA":
            for ($i=0; $i < 4; $i++) { 
                $pass .= (string) rand(0, 9);
            }
            break;
        //Contraseña de 4 dígitos + 1 letra mayús
        case "MEDIA":
            for ($i=0; $i < 4; $i++) { 
                $pass .= (string) rand(0, 9);
            }
            $pass .= substr($lmayus, rand(0, strlen($lminus)), 1);
            break;
        //Contraseña 8 caracteres: dígitos + letra mayús + letra minús + símbolo
        case "ALTA":
            break;
    }
}
else
{
    throw new Exception("Error!");
}
    
