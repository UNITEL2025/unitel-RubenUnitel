<?php
#MainController.php
//Controlador principal de la app (aplicación)

require_once "bd.php";

require_once "classes/asociado.php";
require_once "classes/cliente.php";
require_once "classes/empleado.php";
require_once "classes/producto.php";
require_once "classes/referencia.php";
require_once "classes/venta.php";
require_once "classes/ventas_detalle.php";

require_once "PdfController.php";

//Setear los datos dummies
class MainController {
    public $name; //Nombre público de la página para el usuario
    public $empresa; //Nombre público de la empresa

    public function __construct() {
        $this->empresa = "Piscina Talavera";
    }

    public function mostrarError(string $error) {
        echo '<!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>'.$this->name.'</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            </head>
            <body class="bg-light">

            <div class="container mt-5">
                <h2 class="mb-4">'.$this->name.'</h2>

                <!-- Alertas -->
                <div id="alert-container">
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    '.$error.'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            </body>
            </html>';
    }
}
?>