<?php
#AsociadoController.php

require_once "MainController.php";

class AsociadoController extends MainController {
    public function __construct() {
        $this->name = "Asociados";
    }
}

$controller = new AsociadoController();
$id_cliente = (isset($_GET['id_cliente'])) ? $_GET['id_cliente']:null;
$controller->back = "ClienteController.php?id=".$id_cliente;
$action = (isset($_GET['action'])) ? $_GET['action']:null;
$action = (isset($_POST['guardar'])) ? "guardar":$action;
$msg = "";
switch ($action) {
    case 'nuevo':
        $controller->obj = new asociado();
        $controller->obj->cliente_id = $id_cliente;
        break;

    case 'editar':
        $id = (isset($_GET['id'])) ? $_GET['id']:null;
        if ($id != null) $asociado = asociado::getById($id);
        $controller->obj = $asociado;
        break;

    case 'eliminar':
        $id = (isset($_GET['id'])) ? $_GET['id']:null;
        if ($id != null) $asociado = asociado::getById($id);
        $controller->obj = $asociado;

        $cliente = cliente::getById($controller->obj->cliente_id);
        if ($cliente->asociado_id == $controller->obj->id_asociado) {
          if (count($cliente->asociados) > 0) {
            $cliente->asociado_id = $cliente->asociados[0]->id_asociado;
            $cliente->save();
          }
        }
        $controller->obj->delete();
        header('Location: ClienteController.php?action=editar&id='.$id_cliente);
        break;

    case 'guardar':
        if (isset($_POST["id_asociado"]) > 0 && $_POST["id_asociado"] != "") $controller->obj = asociado::getById((int) $_POST["id_asociado"]);
        else  $controller->obj = new asociado();
        
        $controller->obj->nombre = $_POST["nombre"];
        $controller->obj->dni = $_POST["dni"];
        $controller->obj->notas = $_POST["notas"];
        $controller->obj->cliente_id = $_POST["id_cliente"];
        //TODO Guardar el isTitular

        $controller->obj->save();
        $msg = $controller->msg("success", "Asociado guardado!");
        break;
    
    default:
        $controller->mostrarError("Error! Ocurrio un error inesperado.");
        break;
}

$isTitular = "";
if ($controller->obj->esTitular() == true) $isTitular= "checked";

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

  <div class="container mt-5" style="max-width: 600px;">
    <h2 class="mb-4">'.$controller->name.'</h2>
    '.$msg.'
    <form action="AsociadoController.php" method="POST">
    <input type="hidden" id="id_asociado" name="id_asociado" value="'.$controller->obj->id_asociado.'">
    <input type="hidden" id="id_cliente" name="id_cliente" value="'.$controller->obj->cliente_id.'">

    <div class="mb-3">
        <label for="id" class="form-label">ID</label>
        <input type="text" class="form-control" id="id" placeholder="" readonly value="'.$controller->obj->id_asociado.'"/>
      </div>

    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="" value="'.$controller->obj->nombre.'"/>
      </div>

      <div class="mb-3">
        <label for="dni" class="form-label">DNI</label>
        <input type="text" class="form-control" id="dni" name="dni" placeholder="" value="'.$controller->obj->dni.'"/>
      </div>

      <div class="mb-3">
        <label for="notas" class="form-label">Notas</label>
        <textarea class="form-control" id="notas" name="notas" placeholder="Comentarios...">'.$controller->obj->notas.'</textarea>
      </div>

      <div class="mb-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="isTitular" '.$isTitular.'>
          <label class="form-check-label" for="isTitular">
            Titular
          </label>
        </div>
      </div>

      <div class="mb-3">
        <label for="fecha" class="form-label">Creación</label>
        <input type="text" class="form-control" id="fecha" placeholder="" readonly value="'.date("d/m/Y", strtotime($controller->obj->fecha)).'"/>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <a href="ClienteController.php?action=editar&id='.$controller->obj->cliente_id.'" class="btn btn-secondary">
          <i class="bi bi-house-door-fill me-1"></i> Ir a Cliente
        </a>

        <button type="submit" class="btn btn-primary" name="guardar">
          <i class="bi bi-save-fill me-1"></i> Guardar
        </button>

        <a href="AsociadoController.php?eliminar='.$controller->obj->id_asociado.'" class="btn btn-danger">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
          </svg>
          Eliminar
        </a>
      </div>
    </form>
  </div>

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>';
?>