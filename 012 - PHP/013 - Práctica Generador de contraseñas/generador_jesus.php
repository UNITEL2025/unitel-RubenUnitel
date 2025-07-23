<?php

$seguridad = $_POST["seguridad"];

$num = "0123456789";
$let_min = "abcdefghijklmnopqrstuvwxyz";
$let_may = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$simb = "!@#$%^&*()";

$num_ale = substr(str_shuffle($num),0,4);
$let_min_ale = substr(str_shuffle($let_min),0,1);
$let_may_ale = substr(str_shuffle($let_may),0,1);
$simb_ale = substr(str_shuffle($simb),0,2);

switch ($seguridad) {

    //Baja: contraseña de 4 num
    case "baja":
        
        $password = substr(str_shuffle($num),0,4);
        break;

    //Media: contraseña de 4 num - 1lt min y 1lt may
    case "media":

        $password = (string) str_shuffle($num_ale.$let_min_ale.$let_may_ale);
        break;

    //Alta: contraseña de 4 num - 1lt min - 1lt may y 2 simb
    case "alta":

        $password = str_shuffle("".$num_ale.$let_min_ale.$let_may_ale.$simb_ale);
        break;
}

?>

<html>
    <head>
        <title>Generador de contraseñas</title>
        <meta charset="utf-8">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6 border pt-10">
                    <div class="row text-center mb-4 mt-4">
                        <h3>GENERADOR DE CONTRASEÑAS</h3>
                    </div>
                    <div class="row">
                        <form action="generador.php" method="post">
                            <p>Seguridad: </p>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="radio1" name="seguridad" value="baja">Baja
                                <label class="form-check-label" for="radio1"></label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="radio2" name="seguridad" value="media">Media
                                <label class="form-check-label" for="radio2"></label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="radio3" name="seguridad" value="alta" checked>Alta
                                <label class="form-check-label" for="radio3"></label>
                            </div>
                            <div class="row">
                                <div class="col-10">
                                    <input type="text" class="form-control mt-2" id="password" name="password" value="<?php echo $password; ?>" readonly>
                                </div>
                                <div class="col-2">
                                    <a href="#" onclick="copyPassword()"><i  class="fa-regular fa-copy fa-2x"></i></a>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4">Generar contraseña</button>
                        </form>
                    </div>

                </div>
                <div class="col-3"></div>
            </div>
        </div>
        <script>
            function copyPassword() {
                const input = document.getElementById("password");
                input.select();
                input.setSelectionRange(0,99999);
                document.exeCommand("copy");
                alert("¡Contraseña copiada!");
            }
        </script>
    </body>
</html>