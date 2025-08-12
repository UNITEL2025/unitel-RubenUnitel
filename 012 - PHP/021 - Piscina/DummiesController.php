<?php
#DummiesController.php
//Controlador para cargar datos de ejemplo

require_once "classes/empleado.php";
require_once "classes/cliente.php";
require_once "classes/asociado.php";
require_once "classes/producto.php";
require_once "classes/venta.php";
require_once "classes/ventas_detalle.php";
require_once "classes/referencia.php";
require_once "classes/aforo.php";

//Empleados
/*for ($i=0; $i < 5; $i++) { 
    $item = new empleado();
    $item->nombre = "Nombre Emp ".$i;
    $item->apellidos = "Apellidos Emp ".$i;
    $item->telefono = "6".str_pad((string) $i, 8, "0", STR_PAD_LEFT);
    $item->dni =  str_pad((string) $i, 9, "0", STR_PAD_LEFT)."A";
    $item->save();
}

//Productos
$item = new producto();
$item->nombre = "Adulto Diario";
$item->precio = 3;
$item->tipo = FALSE;
$item->notas = "Nota del producto 0";
$item->ref_ini = 0;
$item->fecha_ini = date("Y-m-d", strtotime("2025-06-20"));
$item->fecha_fin = date("Y-m-d", strtotime("2025-09-04"));
$item->save();

$item = new producto();
$item->nombre = "Infantil Diario";
$item->precio = 2;
$item->tipo = FALSE;
$item->notas = "Nota del producto Infantil Diario";
$item->ref_ini = 0;
$item->fecha_ini = date("Y-m-d", strtotime("2025-06-20"));
$item->fecha_fin = date("Y-m-d", strtotime("2025-09-04"));
$item->save();

$item = new producto();
$item->nombre = "Adulto Sábado y Festivos";
$item->precio = 3.5;
$item->tipo = FALSE;
$item->notas = "Nota del producto Adulto Sábado y Festivos";
$item->ref_ini = 0;
$item->fecha_ini = date("Y-m-d", strtotime("2025-06-20"));
$item->fecha_fin = date("Y-m-d", strtotime("2025-09-04"));
$item->save();

$item = new producto();
$item->nombre = "Infantil Sábado y Festivos";
$item->precio = 2.5;
$item->tipo = FALSE;
$item->notas = "Nota del producto Infantil Sábado y Festivos";
$item->ref_ini = 0;
$item->fecha_ini = date("Y-m-d", strtotime("2025-06-20"));
$item->fecha_fin = date("Y-m-d", strtotime("2025-09-04"));
$item->save();

$item = new producto();
$item->nombre = "Abono Familiar";
$item->precio = 75;
$item->tipo = TRUE;
$item->notas = "Nota del producto Abono Familiar";
$item->ref_ini = 0;
$item->fecha_ini = date("Y-m-d", strtotime("2025-06-20"));
$item->fecha_fin = date("Y-m-d", strtotime("2025-09-04"));
$item->save();

$item = new producto();
$item->nombre = "Abono Individual";
$item->precio = 40;
$item->tipo = TRUE;
$item->notas = "Nota del producto Abono Individual";
$item->ref_ini = 0;
$item->fecha_ini = date("Y-m-d", strtotime("2025-06-20"));
$item->fecha_fin = date("Y-m-d", strtotime("2025-09-04"));
$item->save();

$item = new producto();
$item->nombre = "Abono Infantil";
$item->precio = 33;
$item->tipo = TRUE;
$item->notas = "Nota del producto Abono Infantil";
$item->ref_ini = 0;
$item->fecha_ini = date("Y-m-d", strtotime("2025-06-20"));
$item->fecha_fin = date("Y-m-d", strtotime("2025-09-04"));
$item->save();

$item = new producto();
$item->nombre = "Abono Mayores 65";
$item->precio = 35;
$item->tipo = TRUE;
$item->notas = "Nota del producto Abono Mayores 65";
$item->ref_ini = 0;
$item->fecha_ini = date("Y-m-d", strtotime("2025-06-20"));
$item->fecha_fin = date("Y-m-d", strtotime("2025-09-04"));
$item->save();

$item = new producto();
$item->nombre = "Abono 20 baños";
$item->precio = 30;
$item->tipo = TRUE;
$item->notas = "Nota del producto Abono 20 baños";
$item->ref_ini = 0;
$item->fecha_ini = date("Y-m-d", strtotime("2025-06-20"));
$item->fecha_fin = date("Y-m-d", strtotime("2025-09-04"));
$item->save();

//Clientes + Asociados
for ($i=0; $i < 100; $i++) { 
    $cliente = new cliente();
    $cliente->notas = "Nota de cliente ".$i;
    for ($j=0; $j < 4; $j++) { 
        $aso = new asociado();
        $aso->nombre = "Nombre Aso ".$i."/".$j;
        $aso->dni = str_pad((string) $i, 9, "0", STR_PAD_LEFT)."A";
        $aso->notas = "Nota del cliente ".$i." asociado ".$j;
        $cliente->asociados[] = $aso;
    }
    $cliente->save();
}

//Asociar titular
$clientes = cliente::getAll();
foreach ($clientes as $cliente) {
    $id_asociado = $cliente->asociados[rand(0, count($cliente->asociados) - 1)]->id_asociado;
    $cliente->asociado_id = $id_asociado;
    $cliente->save();
}*/


//bd::deleteAll("ventas");

//Ventas
/*$empleados = empleado::getAll();
$clientes = cliente::getAll();
$tickets = $abonos = array();
foreach (producto::getAll() as $item) {
    if ($item->tipo == FALSE) $tickets[] = $item;
    else $abonos[] = $item;
}

for ($i=0; $i < 1000; $i++) { 
    $item = new venta();

    $tipo = false;
    //Si vendo ticket
    if (rand(0, 1) == 0) {
        $tipo = FALSE;
        $item->cliente_id = null;
        for ($j=0; $j < rand(1,4); $j++) { 
            $detalle = new detalle();
            $producto = $tickets[rand(0, count($tickets) - 1)];
            $detalle->producto_id = $producto->id_producto;
            $detalle->precio = $producto->precio;
            $detalle->ctd = rand(1,3);
            $item->detalles[] = $detalle;//añadir
        }
    }
    //Si vendo abono
    else {
        $tipo = TRUE;
        
        $cliente = $clientes[rand(0, count($clientes) - 1)];
        $item->cliente_id = $cliente->id_cliente;

        $detalle = new detalle();
        $producto = $abonos[rand(0, count($abonos) - 1)];
        $detalle->producto_id = $producto->id_producto;
        $detalle->precio = $producto->precio;
        $detalle->ctd = 1;
        $item->detalles[] = $detalle;//añadir
    }
    
    $item->empleado_id = $empleados[rand(0, count($empleados) - 1)]->id_empleado;
    $item->metodo_pago = venta::$metodos[rand(0, count(venta::$metodos) - 1)];
    $item->save();
}*/

//Ajuste de fechas de ventas
//Inicio: 2025-06-20
//Fin: 2025-09-04
//IMPORTANTE!! Ajustar el save (UPDATE) de ventas con el campo fecha
/*$ventas = venta::getAll();

$start = DateTime::createFromFormat('Y-m-d', '2025-06-20');
$end = DateTime::createFromFormat('Y-m-d', '2025-09-04');

//$interval = $start->diff($end);
//echo $interval->format('%R%a days');

$i = 0;
while($start < $end) {
    for ($j=0; $j < rand(8, 12); $j++) { 
        
        $start->setTime(rand(12, 20), rand(0, 59), rand(0, 59));//NUEVA

        $venta = $ventas[$i];
        $venta->fecha = $start->format("Y-m-d H:i:s");//MODIFICADA
        $venta->save();
        $i++;
    }
    
    $start->modify('+1 day');
}*/

//Actualizar fechas de asociados
/*$items = asociado::getAll();

$start = DateTime::createFromFormat('Y-m-d', '2025-06-20');
$end = DateTime::createFromFormat('Y-m-d', '2025-09-04');

$i = 0;
while($start < $end) {
    for ($j=0; $j < rand(3, 5); $j++) { 
        if (isset($items[$i])) {
            $item = $items[$i];
            $item->fecha = $start->format("Y-m-d");
            $item->save();
            $i++;
        }
    }
    
    $start->modify('+1 day');
}*/

//Añadir aforo
//El aforo debe ir en consecuencia con las ventas
$ventas = venta::getAll(); //Obtengo las ventas
foreach ($ventas as $venta) { //Itero las ventas
    foreach ($venta->detalles as $detalle) { //Dentro cada ventas, itero sus detalles
        $producto = producto::getById($detalle->producto_id); //Qué producto tengo?
        
        //Si es ticket -> Añadimos el aforo según la ctd
        if ($producto->tipo == 0)
        {  
            $item = new aforo(
                null,
                $detalle->ctd,
                $venta->fecha
            );
        
            $item->save();
        }
        //Si es abono, nos inventamos en función al máximo de asociados
        //Para no complicar, los abonos de 20 baños no los tenemos en cuenta a la hora de crear el aforo
        else {
            $start = DateTime::createFromFormat('Y-m-d H:i:s', $venta->fecha);
            $end = DateTime::createFromFormat('Y-m-d', '2025-09-04');

            $cliente = cliente::getById($venta->cliente_id);

            while($start < $end) {
                
                $item = new aforo(
                    null,
                    rand(0, count($cliente->asociados)),
                    $start->format("Y-m-d")
                );
                $item->save();

                $start->modify('+1 day');
            }
        }
    }
}
?>