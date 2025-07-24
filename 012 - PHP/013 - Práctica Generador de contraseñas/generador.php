<?php
$checked = [
    "BAJA" => "",
    "MEDIA" => "",
    "ALTA" => ""
];

//Definimos variables del script
$seguridad; //Me indica si el usuario indica si la quiere baja/media/alta
$pass = ""; //Declaro
$lmayus = "QWERTYUIOPASDFGHJKLZXCVBNM"; //Defino una cadena de texto letras mayús
$lminus = "qwertyuiopasdfghjklzxcvbnm"; //Defino una cadena de texto letras minús
$symbols = "@#$%&/()[]{}";  //Defino una cadena de texto de símbolos

//Obtenemos variables de $_POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["seguridad"]))
{
    //Paso la selección del usuario a una variable
    $seguridad = $_POST["seguridad"];

    //Asigno al array de los radio buttons el valor seleccionado por el usuario
    //$checked["ALTA"] = "checked";
    $checked[$seguridad] = 'checked';

    //Generamos la contraseña
    switch ($seguridad)
    {
        //Contraseña de 4 dígitos
        case "BAJA":
            for ($i=0; $i < 4; $i++) { 
                $pass .= (string) rand(0, 9);
            }
            //Salida: "8569"
            break;
        //Contraseña de 4 dígitos + 1 letra mayús
        case "MEDIA":
            for ($i=0; $i < 4; $i++) { 
                $pass .= (string) rand(0, 9);
            }
            //$pass .= substr($lmayus, rand(0, strlen($lmayus)), 1);
            //substr(cadena, pos inicial, número caracteres)
            //$cadena = $lmayus; Cadena de texto
            //$longitud = strlen($lmayus); //longitud de la cadena
            //$aleatorio = rand(0, $longitud); //Número aleatorio desde cero hasta el límite de la cadena => Ej. 5
            //cadena = "qwertyuiop"
            $pass .= substr($lmayus, rand(0, strlen($lmayus)), 1);
            //Salida: 7412A
            break;
        //Contraseña 8 caracteres: dígitos + letra mayús + letra minús + símbolo
        case "ALTA":
            for ($i=0; $i < 5; $i++) { 
                $pass .= (string) rand(0, 9);
            }
            $pass .= substr($lmayus, rand(0, strlen($lminus)), 1);
            $pass .= substr($lminus, rand(0, strlen($lminus)), 1);
            $pass .= substr($symbols, rand(0, strlen($symbols)), 1);
            //Salida: 4125aA$
            break;
    }
}
else
{
    $checked["BAJA"] = 'checked';
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Generador de contraseñas online</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <div class="container mt-5">
            <div class="card mx-auto shadow" style="max-width: 500px;">
                <div class="card-body">
                    <h4 class="card-title text-center mb-4">Generador de Contraseñas</h4>

                    <form action="generador.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label d-block">Seguridad:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="seguridad" value="BAJA" <?php echo $checked["BAJA"]; ?>
                                <label class="form-check-label">
                                    BAJA<?php $pass?>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="seguridad" value="MEDIA" <?php echo $checked["MEDIA"]; ?>
                                <label class="form-check-label">
                                    MEDIA
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="seguridad" value="ALTA" <?php echo $checked["ALTA"]; ?>
                                <label class="form-check-label">
                                    ALTA
                                </label>
                            </div>
                        </div>

                        <div class="mb-3 d-flex">
                            <input id="password" type="text" class="form-control" placeholder="Contraseña generada" readonly value="<?php echo $pass; ?>">
                            <a href="#" onclick="copyPassword()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" fill="currentColor" class="bi bi-clipboard" viewBox="0 0 16 16">
                                    <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
                                    <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
                                </svg>
                            </a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Generar Contraseña</button>
                    </form>
                </div>
            </div>
        </div>
        <script>
            function copyPassword() {
                const input = document.getElementById("password");
                input.select();
                input.setSelectionRange(0, 99999);
                document.execCommand("copy");
                alert("¡Contraseña copiada!");
            }
        </script>
    </body>
</html>