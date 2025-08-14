<?php
#Index.php

require_once "MainController.php";

class Index extends MainController {
    public $empleados;

    public function __construct() {
        $this->name = "Inicio";
        $this->empleados = empleado::getAll();
        parent::__construct();
    }

    public function getEmpleados() {
        $return = '';
        
        if (count($this->empleados) == 0) return '<p>No existen empleados!</p>';

        foreach ($this->empleados as $empleado) {
            $return .= '<a href="Index.php?id_empleado='.$empleado->id_empleado.'" class="btn btn-primary">'.$empleado->nombre.'</a>';
        }
        return $return;
    }
}

$controller = new Index();

//Abrir sesión
if (isset($_GET["id_empleado"])) {
    $asistencia = new asistencia((int) $_GET["id_empleado"]);
    $asistencia->save();
    header("Location: DsbController.php");
    die();
}
//Cerrar sesión
if (isset($_GET["close"])) {
    if ($controller->asistencia != null) {
        $controller->asistencia->close();
    }
}

//Confirmamos si ya está abierta la sesión
if ($controller->asistencia != null) {
  header("Location: DsbController.php");
  die();
}

echo '<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>'.$controller->name.'</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
  <body class="d-flex justify-content-center align-items-center vh-100">

    <!-- Contenedor vertical con título y botones -->
    <div class="d-flex flex-column gap-4 align-items-center">
      <h1>'.$controller->empresa.'</h1>

      <div class="d-flex flex-column gap-3 w-100" style="max-width: 200px;">
      '.$controller->getEmpleados().'
      </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>';
?>
