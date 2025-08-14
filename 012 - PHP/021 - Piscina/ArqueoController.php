<?php
#ArqueoController.php

require_once "MainController.php";

class ArqueoController extends MainController {
  public $empleado; //empleado que hace el arqueo (el que está logeado)
  public $arqueo; 
  public $btn_save; //Control para activar/deactivar el botón
  public $btn_save_display; //Control para visualizar o no el botón guardar
  public $btn_confirm_display; //Control para visualizar o no el botón confirmar
  public $ventas_total; //Incluye todos los medios de pago
  public $ventas_efectivo; //Incluye sólo ventas en efectivo

    public function __construct() {
        $this->name = "Arqueo";
        $this->arqueo = arqueo::getCurrent(); //Obtengo el arqueo actual (abierto)
        $now = new \DateTime();
        $this->arqueo->fecha_fin = $now->format("Y-m-d H:i:s"); //Seteo fecha final
        //getVentas función NUEVA de la clase ventas que devuelve las ventas
        //según fecha de inicio, fecha de fin, y sólo efectivo o todos los medios de pago
        $this->ventas_total = venta::getVentas($this->arqueo->fecha_ini, $this->arqueo->fecha_fin, false);
        $this->ventas_efectivo = venta::getVentas($this->arqueo->fecha_ini, $this->arqueo->fecha_fin);
        $this->arqueo->ventas = $this->ventas_total;
        $this->empleado = empleado::getById($this->arqueo->empleado_id); //Instancio al empleado
        $this->btn_save = ""; //Por defecto estará activo
        $this->btn_save_display = ""; //Por defecto se mostrará
        $this->btn_confirm_display = 'style="display:none;'; //Por defecto no se muestra
    }
}

$controller = new ArqueoController();

//Si no es correcto -> Fuera
if ($controller->arqueo == null) {
  header("Location: TpvController.php");
}

//Guardamos formulario
if (isset($_POST["guardar"]) || isset($_POST["confirmar"])) {
  $controller->arqueo->cto1 = (double) $_POST["1cto"];
  $controller->arqueo->cto2 = (double) $_POST["2cto"];
  $controller->arqueo->cto5 = (double) $_POST["5cto"];
  $controller->arqueo->cto10 = (double) $_POST["10cto"];
  $controller->arqueo->cto20 = (double) $_POST["20cto"];
  $controller->arqueo->cto50 = (double) $_POST["50cto"];
  $controller->arqueo->euro1 = (double) $_POST["1euro"];
  $controller->arqueo->euro2 = (double) $_POST["2euro"];
  $controller->arqueo->euro5 = (double) $_POST["5euro"];
  $controller->arqueo->euro10 = (double) $_POST["10euro"];
  $controller->arqueo->euro20 = (double) $_POST["20euro"];
  $controller->arqueo->euro50 = (double) $_POST["50euro"];

  $ventas_user = 0;
  $ventas_user += $controller->arqueo->cto1 * 0.01;
  $ventas_user += $controller->arqueo->cto2 * 0.02;
  $ventas_user += $controller->arqueo->cto5 * 0.05;
  $ventas_user += $controller->arqueo->cto10 * 0.1;
  $ventas_user += $controller->arqueo->cto20 * 0.2;
  $ventas_user += $controller->arqueo->cto50 * 0.5;
  $ventas_user += $controller->arqueo->euro1 * 1;
  $ventas_user += $controller->arqueo->euro2 * 2;
  $ventas_user += $controller->arqueo->euro5 * 5;
  $ventas_user += $controller->arqueo->euro10 * 10;
  $ventas_user += $controller->arqueo->euro20 * 20;
  $ventas_user += $controller->arqueo->euro50 * 50;

  $controller->arqueo->descuadre = $controller->ventas_efectivo + $controller->arqueo->fondo - $ventas_user;
  
  if (isset($_POST["guardar"])) {
    if ($controller->arqueo->descuadre > 0) {
      $controller->msg("danger", "Falta importe por valor de: ".$controller->arqueo->descuadre." €");
      $controller->btn_save_display = 'style="display:none;';
      $controller->btn_confirm_display = "";
    }
    else if ($controller->arqueo->descuadre < 0) {
      $controller->msg("danger", "Sobra importe por valor de: ".abs($controller->arqueo->descuadre)." €");
      $controller->btn_save_display = 'style="display:none;';
      $controller->btn_confirm_display = "";
    }
    else {
      $controller->msg("success", "Arqueo confirmado!");
      $controller->arqueo->save();
      $controller->btn_save = "disabled";
    }
  }

  if (isset($_POST["confirmar"])) {
    $controller->msg("success", "Arqueo confirmado!");
    $controller->arqueo->save();
    $controller->btn_save_display = "";
    $controller->btn_confirm_display = 'style="display:none;';
    $controller->btn_save = "disabled";
  }
}

echo '<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>'.$controller->name.'</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body>

  <div class="container mt-5" style="max-width: 1200px;">
    <h2 class="mb-4">'.$controller->name.'</h2>
    <form action="ArqueoController.php" method="POST">
      <div class="row">
        <!-- Columna 1: Información -->
        <div class="col-md-4">
          <div class="mb-3">
            <label for="id" class="form-label">Empleado</label>
            <input type="text" class="form-control" readonly value="'.$controller->empleado->nombre.'"/>
          </div>
          <div class="mb-3">
            <label class="form-label">Apertura</label>
            <input type="text" class="form-control" readonly value="'.date("d/m/Y H:i:s", strtotime($controller->arqueo->fecha_ini)).'"/>
          </div>
          <div class="mb-3">
            <label for="nombre" class="form-label">Fondo de Maniobra</label>
            <input type="text" class="form-control" readonly value="'.$controller->arqueo->fondo.'"/>
          </div>
          <div class="mb-3">
            <label for="dni" class="form-label">Ventas Total</label>
            <input type="text" class="form-control" readonly value="'.$controller->ventas_total.'"/>
          </div>
          <div class="mb-3">
            <label for="dni" class="form-label">Ventas Efectivo</label>
            <input type="text" class="form-control" readonly value="'.$controller->ventas_efectivo.'"/>
          </div>
        </div>

        <!-- Columna 2: Céntimos -->
        <div class="col-md-4">
          <div class="mb-3">
            <label class="form-label">1 cto</label>
            <input type="text" class="form-control" name="1cto" value="'.(isset($_POST["1cto"]) ? $_POST["1cto"]:0).'"/>
          </div>
          <div class="mb-3">
            <label class="form-label">2 cto</label>
            <input type="text" class="form-control" name="2cto" value="'.(isset($_POST["2cto"]) ? $_POST["2cto"]:0).'"/>
          </div>
          <div class="mb-3">
            <label class="form-label">5 cto</label>
            <input type="text" class="form-control" name="5cto" value="'.(isset($_POST["5cto"]) ? $_POST["5cto"]:0).'"/>
          </div>
          <div class="mb-3">
            <label class="form-label">10 cto</label>
            <input type="text" class="form-control" name="10cto" value="'.(isset($_POST["10cto"]) ? $_POST["10cto"]:0).'"/>
          </div>
          <div class="mb-3">
            <label class="form-label">20 cto</label>
            <input type="text" class="form-control" name="20cto" value="'.(isset($_POST["20cto"]) ? $_POST["20cto"]:0).'"/>
          </div>
          <div class="mb-3">
            <label class="form-label">50 cto</label>
            <input type="text" class="form-control" name="50cto" value="'.(isset($_POST["50cto"]) ? $_POST["50cto"]:0).'"/>
          </div>
        </div>

        <!-- Columna 3: Euros -->
        <div class="col-md-4">
          <div class="mb-3">
            <label class="form-label">1 Euro</label>
            <input type="text" class="form-control" name="1euro" value="'.(isset($_POST["1euro"]) ? $_POST["1euro"]:0).'"/>
          </div>
          <div class="mb-3">
            <label class="form-label">2 Euro</label>
            <input type="text" class="form-control" name="2euro" value="'.(isset($_POST["2euro"]) ? $_POST["2euro"]:0).'"/>
          </div>
          <div class="mb-3">
            <label class="form-label">5 Euro</label>
            <input type="text" class="form-control" name="5euro" value="'.(isset($_POST["5euro"]) ? $_POST["5euro"]:0).'"/>
          </div>
          <div class="mb-3">
            <label class="form-label">10 Euro</label>
            <input type="text" class="form-control" name="10euro" value="'.(isset($_POST["10euro"]) ? $_POST["10euro"]:0).'"/>
          </div>
          <div class="mb-3">
            <label class="form-label">20 Euro</label>
            <input type="text" class="form-control" name="20euro" value="'.(isset($_POST["20euro"]) ? $_POST["20euro"]:0).'"/>
          </div>
          <div class="mb-3">
            <label class="form-label">50 Euro</label>
            <input type="text" class="form-control" name="50euro" value="'.(isset($_POST["50euro"]) ? $_POST["50euro"]:0).'"/>
          </div>
        </div>
      </div>

      <!-- Botones -->
      <div class="d-flex justify-content-between mt-4">
        <button type="submit" class="btn btn-primary" name="guardar" '.$controller->btn_save.' '.$controller->btn_save_display.'>
          <i class="bi bi-save-fill me-1"></i> Guardar
        </button>

        <button type="submit" class="btn btn-danger" name="confirmar" '.$controller->btn_confirm_display.'>
          <i class="bi bi-save-fill me-1"></i> Confirmar
        </button>

        <a href="TpvController.php" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left-circle-fill me-1"></i> Volver
        </a>
      </div>
    </form>
  </div>

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
';
?>