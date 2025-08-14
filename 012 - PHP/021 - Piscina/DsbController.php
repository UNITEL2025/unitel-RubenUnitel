<?php
#DbsController.php

require_once "MainController.php";

class DbsController extends MainController {

    public function __construct() {
        $this->name = "Dashboard";
        parent::__construct();
    }

    //Devuelve el número total de ventas
    public function getVentas() {
        $return = "???"; //Definimos variable de retorno

        $start = new \DateTime(); //Definimos la fecha y hora de hoy (fecha de FIN)
        $start->setTime(0, 0, 0); //Modificamos el datetime: 08/08/2025 09:31:00 => 08/08/2025 00:00:00

        $end = new \DateTime(); //Definimos la fecha y hora de hoy (fecha de FIN)
        $end->setTime(23, 59, 59); //Modificamos la hora

        //Montar el sql
        $sql = 'SELECT SUM(vd.ctd) as total 
                FROM ventas_detalle AS vd 
                LEFT JOIN ventas AS v ON v.id_venta = vd.venta_id 
                WHERE fecha BETWEEN "'.$start->format("Y-m-d H:i:s").'" AND "'.$end->format("Y-m-d H:i:s").'";';

        $conn = bd::get();
        if ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql); 
            $stmt->execute();
            $items = $stmt->fetchAll();

            if (isset($items[0]["total"]))
            {
                $return = $items[0]["total"];
            }
            return $return;
        }
        else {
            $this->mostrarError("ERROR! No se puede conectar con la Base de Datos");
        }
    }
    
    //Devuelve el número de asociados en el año en curso (2025)
    public function getAbonados() {
        $return = "???";

        $date = new \DateTime();

        $sql = 'SELECT COUNT(a.id_asociado) as total 
                FROM asociados AS a 
                WHERE fecha BETWEEN "'.$date->format("Y").'-01-01 00:00:00" AND "'.$date->format("Y").'-12-01 23:59:59";';

        $conn = bd::get();
        if ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql); 
            $stmt->execute();
            $items = $stmt->fetchAll();

            if (isset($items[0]["total"]))
            {
                $return = $items[0]["total"];
            }
            return $return;
        }
        else {
            $this->mostrarError("ERROR! No se puede conectar con la Base de Datos");
        }
    }

    //Devuelve el número de personas que han entrado en el día
    public function getAforo() {
        $return = "???";

        $date = new \DateTime();

        $sql = 'SELECT sum(a.ctd) as total 
                FROM aforos AS a 
                WHERE DATE(fecha) = "'.$date->format("Y-m-d").'";';

        $conn = bd::get();
        if ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql); 
            $stmt->execute();
            $items = $stmt->fetchAll();

            if (isset($items[0]["total"]))
            {
                $return = $items[0]["total"];
            }
            return $return;
        }
        else {
            $this->mostrarError("ERROR! No se puede conectar con la Base de Datos");
        }
    }

    //Devuelve el total de ventas realizadas en el día
    public function getImporte() {
        $return = "???";

        $start = new \DateTime();
        $start->setTime(0, 0, 0);

        $end = new \DateTime();
        $end->setTime(23, 59, 59);

        $sql = 'SELECT sum(vd.precio * vd.ctd) as total 
                FROM ventas_detalle AS vd 
                LEFT JOIN ventas AS v ON v.id_venta = vd.venta_id 
                WHERE fecha BETWEEN "'.$start->format("Y-m-d H:i:s").'" AND "'.$end->format("Y-m-d H:i:s").'";';

        $conn = bd::get();
        if ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql); 
            $stmt->execute();
            $items = $stmt->fetchAll();

            if (isset($items[0]["total"]))
            {
                $return = number_format(round($items[0]["total"], 2), 2, ",", ".");
            }
            return $return." €";
        }
        else {
            $this->mostrarError("ERROR! No se puede conectar con la Base de Datos");
        }
    }

    //Gráfica: Devuelve las ventas del día, agrupadas por horas
    public function getVentasDia() {
        //return "[20, 35, 40, 50, 60, 80, 75, 70, 60, 100]";
        $return = array(); //Defino un array para la salida

        $date = new \DateTime(); //Defino la fecha

        $sql = 'SELECT 
                    HOUR(fecha) AS hora,
                    SUM(vd.ctd) AS total
                FROM ventas_detalle AS vd
                LEFT JOIN ventas AS v ON v.id_venta = vd.venta_id
                WHERE DATE(fecha) = "'.$date->format("Y-m-d").'"
                GROUP BY HOUR(fecha)
                ORDER BY hora;';

        $conn = bd::get();
        if ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql); 
            $stmt->execute();
            $items = $stmt->fetchAll();

            for ($i=12; $i <= 21; $i++) {
                $return[$i] = 0;

                foreach ($items as $item) {
                    if ((int) $item["hora"] == $i)
                    {
                        $return[$i] = $item["total"];
                    }
                }
            }

            return "[".implode(",", $return)."]";
        }
        else {
            $this->mostrarError("ERROR! No se puede conectar con la Base de Datos");
        }
    }

    //Gráfica: Devuelve el aforo del día, agrupado por horas
    public function getAforoDia() {
        //return "[20, 35, 40, 50, 60, 80, 75, 70, 60, 100]";
        $return = array(); //Defino un array para la salida

        $date = new \DateTime(); //Defino la fecha
        $sql = 'SELECT 
                    HOUR(fecha) AS hora,
                    SUM(a.ctd) AS total
                FROM aforos AS a
                WHERE fecha BETWEEN "'.$date->format("Y-m-d").' 00:00:00" AND "'.$date->format("Y-m-d").' 23:59:59" '.
                'GROUP BY HOUR(fecha)
                ORDER BY hora;';

        $conn = bd::get();
        if ($conn instanceof PDO) {
            $stmt = $conn->prepare($sql); 
            $stmt->execute();
            $items = $stmt->fetchAll();

            for ($i=12; $i <= 21; $i++) {
                $return[$i] = 0;

                foreach ($items as $item) {
                    if ((int) $item["hora"] == $i)
                    {
                        $return[$i] = $item["total"];
                    }
                }
            }

            return "[".implode(",", $return)."]";
        }
        else {
            $this->mostrarError("ERROR! No se puede conectar con la Base de Datos");
        }
    }
}

$controller = new DbsController();

//Confirmamos si ya está abierta la sesión
if ($controller->asistencia == null) {
  header("Location: Index.php");
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

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <style>
            body {
            min-height: 100vh;
            overflow-x: hidden;
            }
            /* Navbar lateral fijo */
            #sidebar {
            min-width: 250px;
            max-width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: white;
            padding: 1rem;
            }
            #sidebar h2 {
            font-weight: 700;
            margin-bottom: 2rem;
            font-size: 1.5rem;
            text-align: center;
            }
            #sidebar .nav-link {
            color: #adb5bd;
            }
            #sidebar .nav-link:hover, 
            #sidebar .nav-link.active {
            color: white;
            background-color: #495057;
            border-radius: 0.25rem;
            }
            #content {
            margin-left: 250px;
            padding: 2rem;
            }
            .card {
            color: white;
            }
            .card.bg-warning {
            color: black;
            }
        </style>
    </head>
    <body>

    <!-- Sidebar lateral con menú -->
    <nav id="sidebar">
        <h2>'.$controller->empresa.'</h2>
        <h4>'.$controller->asistencia->empleado->nombre.'</h4>

        <ul class="nav flex-column mb-4">
            <li class="nav-item">
                <a class="nav-link" href="TpvController.php?">TPV</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ListController.php?tabla=ventas">Ventas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ListController.php?tabla=clientes">Clientes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ListController.php?tabla=asociados">Asociados</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ListController.php?tabla=productos">Productos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ListController.php?tabla=empleados">Empleados</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Informes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Configuración</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Index.php?close=true">Salir</a>
            </li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div id="content">
        <h1 class="mb-4">Indicadores y gráficos</h1>

        <!-- Tarjetas encima -->
        <div class="row mb-4 g-3">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Ventas del día</h5>
                <p class="card-text fs-3" id="ventasDia">'.$controller->getVentas().'</p>
            </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Número de abonados</h5>
                <p class="card-text fs-3" id="abonados">'.$controller->getAbonados().'</p>
            </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning">
            <div class="card-body">
                <h5 class="card-title">Aforo actual</h5>
                <p class="card-text fs-3" id="aforo">'.$controller->getAforo().'</p>
            </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white">
            <div class="card-body">
                <h5 class="card-title">Importe vendido</h5>
                <p class="card-text fs-3" id="importe">'.$controller->getImporte().'</p>
            </div>
            </div>
        </div>
        </div>

        <!-- Gráficos debajo -->
        <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Ventas del día por hora</div>
            <div class="card-body">
                <canvas id="ventasChart" height="200"></canvas>
            </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">Aforo por hora</div>
            <div class="card-body">
                <canvas id="aforoChart" height="200"></canvas>
            </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para gráficos -->
    <script>
        const horas = ["12:00H", "13:00H", "14:00H", "15:00H", "16:00H", "17:00H", "18:00H", "19:00H", "20:00H", "21:00H"];

        const ventasData = '.$controller->getVentasDia().';
        const aforoData = '.$controller->getAforoDia().';

        const ctxVentas = document.getElementById("ventasChart").getContext("2d");
        const ventasChart = new Chart(ctxVentas, {
        type: "line",
        data: {
            labels: horas,
            datasets: [{
            label: "Ventas",
            data: ventasData,
            borderColor: "rgba(13, 110, 253, 1)",
            backgroundColor: "rgba(13, 110, 253, 0.2)",
            fill: true,
            tension: 0.3,
            pointRadius: 4,
            pointBackgroundColor: "rgba(13, 110, 253, 1)",
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true, position: "top" } },
            scales: {
            y: { beginAtZero: true, title: { display: true, text: "Ventas" } },
            x: { title: { display: true, text: "Hora" } }
            }
        }
        });

        const ctxAforo = document.getElementById("aforoChart").getContext("2d");
        const aforoChart = new Chart(ctxAforo, {
        type: "bar",
        data: {
            labels: horas,
            datasets: [{
            label: "Aforo",
            data: aforoData,
            backgroundColor: "rgba(255, 193, 7, 0.7)",
            borderColor: "rgba(255, 193, 7, 1)",
            borderWidth: 1,
            borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true, position: "top" } },
            scales: {
            y: { beginAtZero: true, title: { display: true, text: "Personas" } },
            x: { title: { display: true, text: "Hora" } }
            }
        }
        });
    </script>
    </body>
</html>';