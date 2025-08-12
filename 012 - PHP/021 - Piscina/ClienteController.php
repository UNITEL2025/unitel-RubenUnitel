<?php
#ClienteController.php

require_once "MainController.php";

class ClienteController extends MainController {
    public function __construct() {
        $this->name = "Cliente";
    }

    public function getRows() {
        $return = '';

        foreach ($this->obj->asociados as $asociado) {
            $htmlTitular = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"/>
                </svg>';

            if ($asociado->esTitular() == false) $htmlTitular = '';
            
            $return .= '<tr>
                            <td>'.$asociado->id_asociado.'</td>
                            <td>'.$htmlTitular.'</td>
                            <td>'.$asociado->nombre.'</td>
                            <td>'.$asociado->dni.'</td>
                            <td>'.date("d/m/Y", strtotime($asociado->fecha)).'</td>
                            <td>
                                <a href="AsociadoController.php?action=editar&id='.$asociado->id_asociado.'" class="btn btn-sm btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                    </svg>
                                </a>
                                <a href="AsociadoController.php?action=eliminar&id='.$asociado->id_asociado.'&id_cliente='.$asociado->cliente_id.'" class="btn btn-sm btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>';    
        }
        return $return;
    }
}

$controller = new ClienteController();
$action = (isset($_GET['action'])) ? $_GET['action']:null;
$action = (isset($_POST['guardar'])) ? "guardar":$action;
$msg = "";
switch ($action) {
    case 'nuevo':
        $controller->obj = new cliente();
        break;

    case 'editar':
        $id = (isset($_GET['id'])) ? $_GET['id']:null;
        if ($id != null) $cliente = cliente::getById($id);
        $controller->obj = $cliente;
        break;

    case 'eliminar':
        $id = (isset($_GET['id'])) ? $_GET['id']:null;
        if ($id != null) $cliente = cliente::getById($id);
        $controller->obj = $cliente;
        $controller->obj->delete();
        header('Location: ListController.php?tabla=clientes');
        break;

    case 'guardar':
        $controller->obj = new cliente();
        $controller->obj->notas = $_POST["notas"];
        $controller->obj->save();
        $msg = $controller->msg("success", "Cliente guardado!");
        break;
    
    default:
        $controller->mostrarError("Error! Ocurrio un error inesperado.");
        break;
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

  <div class="container mt-5" style="max-width: 600px;">
    <h2 class="mb-4">'.$controller->name.'</h2>
    '.$msg.'
    <form action="ClienteController.php" method="POST">
    <div class="mb-3">
        <label for="id" class="form-label">ID</label>
        <input type="text" class="form-control" id="id" placeholder="" readonly value="'.$controller->obj->id_cliente.'"/>
      </div>

    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" placeholder="" readonly value="'.$controller->obj->getTitularNombre().'"/>
      </div>

      <div class="mb-3">
        <label for="dni" class="form-label">DNI</label>
        <input type="text" class="form-control" id="dni" placeholder="" readonly value="'.$controller->obj->getTitularDni().'"/>
      </div>

      <div class="mb-3">
        <label for="notas" class="form-label">Notas</label>
        <textarea class="form-control" id="notas" name="notas" placeholder="Comentarios...">'.$controller->obj->notas.'</textarea>
      </div>

      <div class="mb-3">
        <label for="fecha" class="form-label">Creación</label>
        <input type="text" class="form-control" id="fecha" placeholder="" readonly value="'.date("d/m/Y", strtotime($controller->obj->fecha)).'"/>
      </div>

      <div class="mb-3">
        <h4>Asociados</h4>
        <a href="AsociadoController.php?action=nuevo&id_cliente='.$controller->obj->id_cliente.'" class="btn btn-success d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
            </svg>
        </a>
      </div>
      <div class="mb-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Titular</th>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody id="tabla-clientes">
                '.$controller->getRows().'
                </tbody>
            </table>
        </div>
        </div>

      <div class="d-flex justify-content-between mt-4">
        <a href="DsbController.php" class="btn btn-secondary">
          <i class="bi bi-house-door-fill me-1"></i> Ir a Inicio
        </a>

        <button type="submit" class="btn btn-primary" name="guardar">
          <i class="bi bi-save-fill me-1"></i> Guardar
        </button>

        <a href="ListController.php?tabla=clientes" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left-circle-fill me-1"></i> Volver
        </a>
      </div>
    </form>
  </div>

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>';
?>