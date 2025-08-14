<?php
#TpvController.php

require_once "MainController.php";

class TpvController extends MainController {
    public $productos;

    public function __construct() {
      $this->name = "TPV";
      $this->productos = array();

      foreach (producto::getToday() as $item) {
        $this->productos[] = array(
          "id" => $item["id_producto"],
          "name" => $item["nombre"],
          "price" => $item["precio"]
        );
      }
      $this->productos = json_encode($this->productos);
      parent::__construct();
    }
}

$controller = new TpvController();

//Comprobamos que exista un empleado logeado
if ($controller->asistencia == null) {
  header("Location: Index.php");
}

//Abrimos arqueo
If (isset($_POST["fondo"])) {
  $arqueo = new arqueo();
  $arqueo->empleado_id = $controller->asistencia->empleado_id;
  $arqueo->fondo = $_POST["fondo"];
  $arqueo->save();
}

//Comprobamos si hay abierto un arqueo
if (arqueo::getCurrent() == null) {
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
                <h1>Apertura de Arqueo</h1>

                <form action="TpvController.php?arqueo=true" method="POST">
                  <div class="mb-3">
                    <label class="form-label">Fondo de maniobra</label>
                    <input type="text" class="form-control" id="fondo" name="fondo"/>
                  </div>
                  <button type="submit" class="btn btn-primary" name="guardar">
                    <i class="bi bi-save-fill me-1"></i> ABRIR ARQUEO
                  </button>
                  <a href="DsbController.php" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left-circle-fill me-1"></i> Volver
                  </a>
                </form>
              </div>

              <!-- Bootstrap 5 JS Bundle -->
              <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            </body>
          </html>';
          die();
}

if (isset($_POST['data'])) {
  try {
    $items = json_decode($_POST['data'], true); //Obtener la variable _POST (array productos)

    $venta = new venta();
    $venta->empleado_id = 1; //TODO
    $venta->metodo_pago = venta::$metodos[(int) $_POST['metodo']];
    foreach ($items as $item) {
      $detalle = new detalle();
      $detalle->producto_id = $item["id"];
      $detalle->precio = $item["price"];
      $detalle->ctd = $item["quantity"];

      $venta->detalles[] = $detalle;

      //Añadimos el aforo
      $aforo = new aforo();
      $aforo->ctd = $item["quantity"];
      $aforo->save();
    }
    $venta = $venta->save();

    echo $venta->id_venta;    
  } catch (\Throwable $th) {
    echo json_encode($th);
  }
  die();
}

//Control de impresión de ticket
if (isset($_GET["print_venta"])) {
  $venta = venta::getById($_GET["print_venta"]);
  $pdf = new PdfController();
  $pdf->createTicket($venta);
}

echo '<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TPV Táctil - Cobros</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      padding: 20px;
      background: #f8f9fa;
    }
    .btn-producto {
      width: 100%;
      margin-bottom: 8px;
      display: flex;
      justify-content: space-between;
      font-weight: 600;
    }
    .num-pad {
  display: grid !important;
  grid-template-columns: repeat(3, 1fr) !important;
  gap: 8px !important;
  width: 100% !important;
  max-width: 320px; /* opcional para limitar el tamaño máximo */
  margin: 0 auto; /* centrar si queda más pequeño */
}
.num-pad button {
  width: 100% !important;
  height: 60px !important;
  font-size: 1.5rem !important;
}
    .cantidad-controls button {
      width: 30px;
      height: 30px;
      padding: 0;
      font-weight: bold;
    }
    .cantidad-controls span {
      width: 25px;
      display: inline-block;
      text-align: center;
      font-weight: 600;
    }
    .detalle-venta table {
      width: 100%;
    }
  </style>
</head>
<body>

    <div class="d-flex align-items-center justify-content-between mb-4">
      <a href="DsbController.php" class="btn btn-outline-primary" aria-label="Ir a inicio">
        <i class="bi bi-house-door-fill"></i>
      </a>
      <a href="ArqueoController.php" class="btn btn-outline-primary" aria-label="Cerrar Arqueo">
        <i class="bi bi-x-square"></i>
      </a>
      <h1 class="m-0 text-center flex-grow-1">TPV Táctil - Cobros</h1>
      <div style="width: 38px;"></div> <!-- Espacio para balancear el botón y centrar título -->
    </div>


  <div class="container-fluid">

    <div class="row g-3">

      <!-- Productos (Columna izquierda) -->
      <div class="col-md-3 col-sm-12" id="productosList" aria-label="Lista de productos">
        <!-- Los botones de producto se generan con JS -->
      </div>

      <!-- Detalle de venta (Columna central) -->
      <div class="col-md-6 col-sm-12 detalle-venta">
        <div id="alert_ok" hidden>
          <div class="alert alert-success d-flex align-items-center alert-dismissible" role="alert">
            <div>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
                <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2 2 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a10 10 0 0 0-.443.05 9.4 9.4 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a9 9 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.2 2.2 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.9.9 0 0 1-.121.416c-.165.288-.503.56-1.066.56z"/>
              </svg>
              Venta creada correctamente
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>
        </div>

        <div id="alert_ko" hidden>
          <div class="alert alert-danger d-flex align-items-center alert-dismissible" role="alert">
            <div>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-radioactive" viewBox="0 0 16 16">
                <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8"/>
                <path d="M9.653 5.496A3 3 0 0 0 8 5c-.61 0-1.179.183-1.653.496L4.694 2.992A5.97 5.97 0 0 1 8 2c1.222 0 2.358.365 3.306.992zm1.342 2.324a3 3 0 0 1-.884 2.312 3 3 0 0 1-.769.552l1.342 2.683c.57-.286 1.09-.66 1.538-1.103a6 6 0 0 0 1.767-4.624zm-5.679 5.548 1.342-2.684A3 3 0 0 1 5.005 7.82l-2.994-.18a6 6 0 0 0 3.306 5.728ZM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0"/>
              </svg>
              Error! Ocurrió un error inesperado. Contacte con el administrador del sistema.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>
        </div>

        <h4>Detalle de venta</h4>
        <table class="table table-striped" aria-label="Detalle de productos añadidos a la venta">
          <thead>
            <tr>
              <th>Producto</th>
              <th class="text-center">Cantidad</th>
              <th class="text-end">Importe</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody id="detalleVentaBody">
            <tr><td colspan="4" class="text-center text-muted fst-italic">No hay productos añadidos</td></tr>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="2" class="text-end">Total:</th>
              <th id="totalDisplay" class="text-end">0.00 €</th>
              <th></th>
            </tr>
          </tfoot>
        </table>
      </div>

      <!-- Columna derecha: importe recibido, devolución, teclado y método de pago -->
      <div class="col-md-3 col-sm-12">
        <h5 class="mb-3">'.$controller->asistencia->empleado->nombre.'</h5>
        <h4 class="mb-3">Importe recibido</h4>
        <input type="text" id="importeRecibido" class="form-control mb-3" placeholder="0.00" readonly aria-describedby="ayudaImporteRecibido" />
        <div id="ayudaImporteRecibido" class="form-text mb-4">Usa el teclado para ingresar importe recibido</div>

        <label for="importeDevolver" class="form-label">Importe a devolver</label>
        <input type="text" id="importeDevolver" class="form-control mb-4" placeholder="0.00" readonly aria-live="polite" />

        <div class="num-pad d-grid gap-2" role="group" aria-label="Teclado numérico para importe recibido" style="grid-template-columns: repeat(3, 60px); display: grid;">
          <button class="btn btn-outline-secondary" data-key="7">7</button>
          <button class="btn btn-outline-secondary" data-key="8">8</button>
          <button class="btn btn-outline-secondary" data-key="9">9</button>

          <button class="btn btn-outline-secondary" data-key="4">4</button>
          <button class="btn btn-outline-secondary" data-key="5">5</button>
          <button class="btn btn-outline-secondary" data-key="6">6</button>

          <button class="btn btn-outline-secondary" data-key="1">1</button>
          <button class="btn btn-outline-secondary" data-key="2">2</button>
          <button class="btn btn-outline-secondary" data-key="3">3</button>

          <button class="btn btn-outline-secondary" data-key=".">.</button>
          <button class="btn btn-outline-secondary" data-key="0">0</button>
          <button class="btn btn-danger" id="clearInput" aria-label="Borrar entrada">C</button>
        </div>

        <h4 class="mt-4 mb-3">Método de cobro</h4>
        <div class="payment-methods d-flex flex-column" role="group" aria-label="Botones de método de cobro">
          <button class="btn btn-success mb-2" onclick="pagar(0);">
            <i class="bi bi-cash-stack me-2"></i>EFECTIVO
          </button>
          <button class="btn btn-primary mb-2" onclick="pagar(1);">
            <i class="bi bi-credit-card me-2"></i>TARJETA
          </button>
          <button class="btn btn-warning mb-2" onclick="pagar(2);">
            <i class="bi bi-phone me-2"></i>BIZUM
          </button>
          <a id="imprimir" href="#" target="_blank"></a>
        </div>
      </div>

    </div>
  </div>

  <script>
    const productos = '.$controller->productos.'
  </script>

  <!-- Bootstrap 5 JS Bundle (Popper + Bootstrap JS) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/tpv_script.js" rel="javascript"></script>
</body>
</html>';
?>