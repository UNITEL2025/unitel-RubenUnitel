<?php

    //Añadimos los archivos auxiliares
    require_once "class/customer.php";
    require_once "class/connection.php";

    //Definimos variables que usaremos como globales
    $error_msj = ""; //La usaremos para añadir los mensaje de error que puedan surgir durante la ejecución
    $step = 0; //Define el estado de ejecución: error, formulario, listado...
    //0 => Error de conexión
    //1 => Mostrar el listado de clientes

    //Inicilizar la BBDD
    $status = conn::init();  //Me devuelve un array
    
    if ($status["status"] == TRUE) {
        $step = 1; //Si estado es TRUE -> Mostramos listado de clientes
    }
    else {
        $step = 0; //Si no hay tenido éxito, es decir, que status sea FALSE
        $error_msj = $status["msj"];
    }


    //Función que se llama desde el HTML y que "piensa" lo que hay que hacer
    function getHTML() {
        global $step;
        global $error_msj;

        //Zona que controla que HTML se debe mostrar
        //Dependiendo del valor de $step mostraremos una cosa u otra
        //Mostramos mensaje de error
        if ($step == 0) //-> Estamos en error de conexión
        {
            showAlert("danger", $error_msj);
        }
        //Mostramos el listado
        else if ($step == 1) {
            echo
                '<div class="container mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Listado de Clientes</h2>
                        <a href="#" class="btn btn-success">+ Nuevo Cliente</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Creación</th>
                                    <th>Actualización</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-clientes">';

                            foreach (customer::getAll() as $item) {
                                echo '<tr>
                                    <td>'.$item->id.'</td>
                                    <td>'.$item->firstname.'</td>
                                    <td>'.$item->lastname.'</td>
                                    <td>'.$item->phone.'</td>
                                    <td>'.$item->email.'</td>
                                    <td>'.$item->dateCreate.'</td>
                                    <td>'.$item->dateUpdate.'</td>
                                    <td>
                                        <a href="formulario.html?id=1" class="btn btn-sm btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                </svg>
                                        </a>
                                    </td>
                                </tr>';
                            }
                            echo '</tbody>
                        </table>
                    </div>
                </div>';
        }
    }

    //Función genérica para mostrar mensajes
    function showAlert(string $str, string $msj) {
        echo
            '<div class="container mt-5">
                <!-- Alertas -->
                <div id="alert-container">
                    <div class="alert alert-'.$str.' alert-dismissible fade show mt-3" role="alert">
                    '.$msj.'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>';   
    }    
?>

<!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Formulario de Usuario</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body class="bg-light">
            <?php getHTML(); ?>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        </body>
    </html>