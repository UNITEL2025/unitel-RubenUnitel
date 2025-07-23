<?php
// http://localhost/Repositorio/unitel2025-belengarciar/PHP/Contrase%C3%B1as/generador.php
$seguridad = $_POST["seguridad"];
$pass;
$caracteres = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()";

switch ($seguridad) {
    case "BAJA":
        $pass = str_pad(rand(0,9999), 4, 0, STR_PAD_LEFT); 
        break;
    case "MEDIA":
        $contrasena = str_pad(rand(0,9999), 4, 0, STR_PAD_LEFT) .substr(chr(rand(ord(strtoupper("a")), ord(strtoupper("z")))), 0, 1);
        $pass = substr(str_shuffle($contrasena), 0, 5);
        break;
    case "ALTA":
        $pass = substr(str_shuffle($caracteres), 0, 8);
        break;
}
?>

<!DOCTYPE html>
<html lang="es";>
    <head>
        <title>Generador de Contraseñas</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    <div class="row">
                        <h1 class="text-center">GENERADOR DE PASS</h1>
                    </div>
                    <div class="row">
                        <h4 class="text-center">SEGURIDAD</h4>
                    </div>
                    <div class="row text-center">
                        <form action="generador_belen.php" method="POST">
                            <div class="form-check-inline mb-3">
                                <input class="form-check-input" type="radio" name="seguridad" id="radioDefault1" value="BAJA">
                                <label class="form-check-label" for="seguridad1">BAJA</label>
                            </div>
                            <div class="form-check-inline mb-3">
                                <input class="form-check-input" type="radio" name="seguridad" id="radioDefault2" value="MEDIA">
                                <label class="form-check-label" for="seguridad2">MEDIA</label>
                            </div>
                            <div class="form-check-inline mb-3">
                                <input class="form-check-input" type="radio" name="seguridad" id="radioDefault2" value="ALTA" checked>
                                <label class="form-check-label" for="seguridad3">ALTA</label>
                            </div>
                            <div class="row">
                                <div class="col-11 mb-3">
                                    <input type="text" class="form-control" id="text" name="password" value="VALOR_PASS" readonly>
                                </div>
                                <div class="col-1 mt-1">
                                    <a href="#" onclick="copyPassword()">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clipboard" viewBox="0 0 16 16">
                                            <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
                                            <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Generar contraseña</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-3"></div>
            </div>
        </div>
        <script>
            function copyPassword() {
                const input = document.getElementById("text");
                input.select();
                input.setSelectionRange(0,99999);
                document.execCommand("copy");
                alert("¡Contraseña copiada!");
            }
        </script>
    </body>
</html>