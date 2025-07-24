<?php
# http://localhost/repo/unitel-RubenUnitel/012%20-%20PHP/012%20-%20Pr%C3%A1ctica%20Test%20Online/test_online.php

//Incluyo la clase "pregunta"
require "clases/pregunta.php";
require "clases/juego.php";

if(isset($_COOKIE["unitel_game"]))
{
    $game = juego::getById((int) $_COOKIE["unitel_game"]);
}
else
{
    $game = new juego();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["start"]) && isset($_POST["nombre"])) {
        $game->name = $_POST["nombre"]; //Guardo el nombre
        $game->step = 1; //Paso de preguntas
        $game->save();

        setcookie("unitel_game", $game->id_juego, time() + (86400 * 30), "/");
    } else if (isset($_POST["respuesta"])) {
        //¿Estoy en la última?
        if ($game->last_ask == count($game->test) - 1) {
            $game->step = 2;

            $game->respuestas[$game->last_ask] = $_POST["respuesta"];
            $game->last_ask++;

            setcookie("unitel_game", "", time() - 3600, "/");
            unset($_COOKIE["unitel_game"]);
        ///¿O me quedan preguntas en el test?
        } else {
            $game->respuestas[$game->last_ask] = $_POST["respuesta"];
            $game->last_ask++;
        }        
        
        $game->save();
    } else if (isset($_POST["restart"])) {
        $game = new juego();
        $game->save();
        setcookie("unitel_game", $game->id_juego, time() + (86400 * 30), "/");
    }
}


function getHTML()
{
    global $game;

    if ($game->step === 0)
    {
        echo '<body class="bg-primary text-white d-flex align-items-center justify-content-center vh-100">
                <div class="text-center">
                    <h1 class="mb-4">¡Bienvenido!</h1>
                    <form action="test_online.php" method="post">
                    <div class="mb-3">
                        <input type="text" name="nombre" class="form-control form-control-lg" placeholder="Ingresa tu nombre" required>
                    </div>
                    <button type="submit" class="btn btn-light btn-lg" name="start">Iniciar Juego</button>
                    </form>
                </div>
            </body>';
    }
    else if ($game->step === 1)
    {
        //id de la pregunta actual?¿
        /*$pos = $game->last_ask; //1 (2da pregunta) Puede tomar valores: 0/1/2/3/4/5
        //Array de id de preguntas -> Nos indica la pregunta por la que vamos
        $id_pregunta = $game->test[$pos] //Devuelve //Id_Pregunta = 8
        $pregunta = pregunta::getById($id_pregunta); //Instancio la pregunta 8
        echo $pregunta->pregunta;

        pregunta::getById($game->test[$game->last_ask])->pregunta*/

        echo '<body class="bg-dark text-white">
                <div class="container py-5 text-center">
                    <h2 class="mb-4">'.pregunta::getById($game->test[$game->last_ask])->pregunta.'</h2>
                    <form action="test_online.php" method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-danger w-100 respuesta-btn" name="respuesta" value="0">'.pregunta::getById($game->test[$game->last_ask])->respuestas[0].'</button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary w-100 respuesta-btn" name="respuesta" value="1">'.pregunta::getById($game->test[$game->last_ask])->respuestas[1].'</button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success w-100 respuesta-btn" name="respuesta" value="2">'.pregunta::getById($game->test[$game->last_ask])->respuestas[2].'</button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-warning w-100 respuesta-btn" name="respuesta" value="3">'.pregunta::getById($game->test[$game->last_ask])->respuestas[3].'</button>
                            </div>
                        </div>
                    </form>
                </div>
            </body>';
    }
    else if ($game->step === 2) {
        $resume = $game->getResume();
        
        echo '<body class="bg-success text-white d-flex flex-column align-items-center justify-content-center vh-100">
                <div class="text-center">
                    <h1 class="mb-4">¡Juego terminado!</h1>
                    <p class="fs-3 mb-4">Gracias por participar, ' . htmlspecialchars($game->name) . '.</p>
                    <p class="fs-4">Has acertado '.$resume["aciertos"].' de '.$resume["total"].' preguntas.</p>
                    <p class="fs-4">Has completado el test.</p>
                    <form action="test_online.php" method="post">
                        <button type="submit" class="btn btn-light btn-lg" name="restart">Volver a jugar</button>
                    </form>
                </div>
        </body>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>UNITEL Games Studios</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .respuesta-btn {
      height: 120px;
      font-size: 1.5rem;
    }
  </style>
</head>
<?php getHTML(); ?>
</html>