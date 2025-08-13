<?php
#ListController.php

//Antes de este controlador hay que hacer el MainController
//Ya que ListController depende del superior (MainController)
//En cliente.php hay que crear una función getTitular() que devuelva un objeto "asociado"
//El HTML del listado está en la carpeta "plantillas" del proyecto

require_once "MainController.php";

class ListController extends MainController {
    public $tabla; //Tabla de la bd a mostrar -> Nos llegará desde $_POST
    public $items; //Listado de elementos de la tabla (objetos)
    public $headers; //Listado de la cabecera de la tabla -> array()
    public $newController;
    /*$headers["tabla1"][] = "Campo 1";
    $headers["tabla1"][] = "Campo 2";
    $headers["tabla2"][] = "Campo 1";...*/
    

    //Constructor
    //Asignamos la tabla
    //Asignamos el nombre para mostrar al usuario -> $this->name (MainController)
    //Chequeamos si existe la tabla
    //Si? Cargamos los items; No?Mostramos mensaje de error del MainController
    //Definimos un array con las cabeceras de cada tabla -> $headers
    public function __construct(string $tabla) {
        $this->tabla = strtolower($tabla); //Transformamos el nombre de la tabla en minús
        $this->name = "Listado de ".ucfirst($this->tabla); //Capitalizamos el nombre de la tabla para mostrar al usuario
        //Si existe la tabla
        if ($this->check() == true) {
            switch ($this->tabla) {
                case 'clientes':
                    $this->items = cliente::getAll($this->tabla);
                    $this->newController = "ClienteController.php?action=nuevo";
                    break;
                
                case 'empleados':
                    $this->items = empleado::getAll($this->tabla);
                    $this->newController = "EmpleadoController.php?action=nuevo";
                    break;

                case 'productos':
                    $this->items = producto::getAll($this->tabla);
                    $this->newController = "ProductoController.php?action=nuevo";
                    break;

                case 'ventas':
                    $this->items = venta::getAll($this->tabla);
                    $this->newController = null;
                    break;

                case 'asociados':
                    $this->items = asociado::getAll($this->tabla);
                    $this->newController = "AsociadoController.php?action=nuevo";
                    break;
            }
        }
        //Cuando no existe la tabla...
        else {
            $this->mostrarError("ERROR! No existe la tabla");
        }
        //Definimos las cabeceras
        $this->headers["clientes"][] = "ID";
        $this->headers["clientes"][] = "Nombre";
        $this->headers["clientes"][] = "DNI";
        $this->headers["clientes"][] = "Num Asoc";
        $this->headers["clientes"][] = "Fecha";
        $this->headers["clientes"][] = "Acciones";

        $this->headers["empleados"][] = "ID";
        $this->headers["empleados"][] = "Nombre";
        $this->headers["empleados"][] = "Apellidos";
        $this->headers["empleados"][] = "Teléfono";
        $this->headers["empleados"][] = "DNI";
        $this->headers["empleados"][] = "Acciones";

        $this->headers["productos"][] = "ID";
        $this->headers["productos"][] = "Nombre";
        $this->headers["productos"][] = "Tipo";
        $this->headers["productos"][] = "Ref";
        $this->headers["productos"][] = "Fecha";
        $this->headers["productos"][] = "Inicio";
        $this->headers["productos"][] = "Finaliza";
        $this->headers["productos"][] = "Acciones";

        $this->headers["ventas"][] = "ID";
        $this->headers["ventas"][] = "Cliente";
        $this->headers["ventas"][] = "Empleado";
        $this->headers["ventas"][] = "Método";
        $this->headers["ventas"][] = "Total";
        $this->headers["ventas"][] = "Fecha";
        $this->headers["ventas"][] = "Acciones";

        $this->headers["asociados"][] = "ID";
        $this->headers["asociados"][] = "Nombre";
        $this->headers["asociados"][] = "DNI";
        $this->headers["asociados"][] = "Fecha";
        $this->headers["asociados"][] = "Acciones";
    }

    //Devuelve el HTML de las cabeceras de las tablas -> $headers
    //Se obtiene de la variable que hemos definido en el constructor
    public function getHeaders() : string {

        $return = "<tr>"; 
        foreach ($this->headers[$this->tabla] as $key => $value) {
            $return .= '<th>'.$value.'</th>';
        }
        $return .= "</tr>";

        return $return;
    }

    //Devuelve el HTML con las filas de la tabla -> $items
    public function getRows() : string { 
        $return = "";
        
        foreach ($this->items as $item) {
            switch ($this->tabla) {
                case 'clientes':
                    $return .= "<tr>";
                    $return .= '<td>'.$item->id_cliente.'</td>';
                    $return .= '<td>'.$item->getTitularNombre().'</td>';
                    $return .= '<td>'.$item->getTitularDni().'</td>';
                    $return .= '<td>'.count($item->asociados).'</td>';
                    $return .= '<td>'.date("d/m/Y", strtotime($item->fecha)).'</td>';
                    $return .= '<td>
                                    <a href="ClienteController.php?action=editar&id='.$item->id_cliente.'" class="btn btn-sm btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                        </svg>
                                    </a>
                                    <a href="ClienteController.php?action=eliminar&id='.$item->id_cliente.'" class="btn btn-sm btn-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                        </svg>
                                    </a>
                                </td>';
                                $return .= "</tr>";
                    break;
                
                case 'asociados':
                    $return .= "<tr>";
                    $return .= '<td>'.$item->id_asociado.'</td>';
                    $return .= '<td>'.$item->nombre.'</td>';
                    $return .= '<td>'.$item->dni.'</td>';
                    $return .= '<td>'.date("d/m/Y", strtotime($item->fecha)).'</td>';
                    $return .= '<td>
                                    <a href="AsociadoController.php?action=editar&id='.$item->id_asociado.'" class="btn btn-sm btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                        </svg>
                                    </a>
                                    <a href="ClienteController.php?action=editar&id='.$item->cliente_id.'" class="btn btn-sm btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                        </svg>
                                    </a>
                                    <a href="AsociadoController.php?action=eliminar&id='.$item->id_asociado.'" class="btn btn-sm btn-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                        </svg>
                                    </a>
                                </td>';
                                $return .= "</tr>";
                    break;

                case 'empleados':
                    $return .= "<tr>";
                    $return .= '<td>'.$item->id_empleado.'</td>';
                    $return .= '<td>'.$item->nombre.'</td>';
                    $return .= '<td>'.$item->apellidos.'</td>';
                    $return .= '<td>'.$item->telefono.'</td>';
                    $return .= '<td>'.$item->dni.'</td>';
                    $return .= '<td>
                                    <a href="EmpleadoController.php?action=editar&id='.$item->id_empleado.'" class="btn btn-sm btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                        </svg>
                                    </a>
                                    <a href="EmpleadoController.php?action=eliminar&id='.$item->id_empleado.'" class="btn btn-sm btn-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                        </svg>
                                    </a>
                                </td>';
                                $return .= "</tr>";
                    break;

                case 'productos':
                    $return .= "<tr>";
                    $return .= '<td>'.$item->id_producto.'</td>';
                    $return .= '<td>'.$item->nombre.'</td>';
                    if ($item->tipo == 0) $return .= '<td><span class="badge bg-primary">TICKET</span></td>';
                    else $return .= '<td><span class="badge bg-warning">ABONO</span></td>';
                    $return .= '<td>'.$item->ref_ini.'</td>';
                    $return .= '<td>'.date("d/m/Y", strtotime($item->fecha)).'</td>';
                    $return .= '<td>'.date("d/m/Y H:i:s", strtotime($item->fecha_ini)).'</td>';
                    $return .= '<td>'.date("d/m/Y H:i:s", strtotime($item->fecha_fin)).'</td>';
                    $return .= '<td>
                                    <a href="ProductoController.php?action=editar&id='.$item->id_producto.'" class="btn btn-sm btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                        </svg>
                                    </a>
                                    <a href="ProductoController.php?action=eliminar&id='.$item->id_producto.'" class="btn btn-sm btn-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                        </svg>
                                    </a>
                                </td>';
                                $return .= "</tr>";
                    break;

                case 'ventas':
                    $return .= "<tr>";
                    $return .= '<td>'.$item->id_venta.'</td>';
                    if ($item->cliente_id == null) {
                        $return .= '<td></td>';
                    }
                    else {
                        $cliente = cliente::getById($item->cliente_id);
                        if ($cliente != null) {
                            $return .= '<td><a href="ClienteController.php?id='.$cliente->id_cliente.'">'.$cliente->getTitular()->nombre.'</a></td>';    
                        }
                        else {
                            $return .= '<td>Desconocido</td>';    
                        }
                    }
                    if ($item->empleado_id == null) {
                        $return .= '<td></td>';
                    }
                    else {
                        $empleado = empleado::getById($item->empleado_id);
                        if ($empleado != null) {
                            $return .= '<td><a href="EmpleadoController.php?id='.$empleado->id_empleado.'">'.$empleado->nombre.'</a></td>';    
                        }
                        else {
                            $return .= '<td>Desconocido</td>';    
                        }
                    }
                    switch ($item->metodo_pago) {

                        case 'TARJETA':
                            $return .= '<td><span class="badge bg-info">TARJETA</span></td>';
                            break;

                        case 'BIZUM':
                            $return .= '<td><span class="badge bg-warning">BIZUM</span></td>';
                            break;

                        case 'EFECTIVO':
                            $return .= '<td><span class="badge bg-success">EFECTIVO</span></td>';
                            break;
                        
                        default:
                            $return .= '<td><span class="badge bg-secondary">DESCONOCIDO</span></td>';
                            break;
                    }
                    $return .= '<td>'.number_format($item->getTotal(), 2, ",", ".").' €</td>';
                    $return .= '<td>'.date("d/m/Y H:i:s", strtotime($item->fecha)).'</td>';
                    $return .= '<td>
                                    <a href="VentaController.php?action=ver&id='.$item->id_venta.'" class="btn btn-sm btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                        </svg>
                                    </a>
                                    <a href="VentaController.php?action=devolver&id='.$item->id_venta.'" class="btn btn-sm btn-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                        </svg>
                                    </a>
                                    <a href="TpvController.php?print_venta='.$item->id_venta.'" class="btn btn-sm btn-primary" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
                                        <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1"/>
                                        </svg>
                                    </a>
                                </td>';
                                $return .= "</tr>";
                    break;
            }
        }
        return $return;
    }

    //Chequea si existe la tabla en la BD
    public function check() : bool {
        return in_array($this->tabla, bd::getTablas());
    }

    public function getLinkNew() {
        if ($this->newController != null)
        {
            return '<a href="'.$this->newController.'&tabla='.$this->tabla.'" class="btn btn-success d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                </a>';
        }
        return "";
    }

    public function toExport() {
        $return = array(
            "data" => array(),
            "len" => 0
        );

        switch ($this->tabla) {
            case 'clientes':
                $return["len"] = array(15, 80, 30, 20, 30);
                foreach ($this->items as $item) {
                    $return["data"][] = array(
                        $item->id_cliente,
                        $item->getTitular()->nombre,
                        $item->getTitular()->dni,
                        count($item->asociados),
                        date("d/m/Y", strtotime($item->fecha))
                    );
                }
                break;

            case 'empleados':
                $return["len"] = array(15, 80, 30, 30, 30);
                foreach ($this->items as $item) {
                    $return["data"][] = array(
                        $item->id_empleado,
                        $item->nombre,
                        $item->dni,
                        $item->telefono,
                        $item->dni
                    );
                }
                break;

            case 'productos':
                $return["len"] = array(15, 80, 20, 20, 30, 50, 50);
                foreach ($this->items as $item) {
                    $return["data"][] = array(
                        $item->id_producto,
                        $item->nombre,
                        ($item->tipo == false) ? "Ticket":"Abono",
                        $item->ref_ini,
                        date("d/m/Y", strtotime($item->fecha)),
                        date("d/m/Y H:i:s", strtotime($item->fecha_ini)),
                        date("d/m/Y H:i:s", strtotime($item->fecha_fin))
                    );
                }
                break;

            case 'ventas':
                $return["len"] = array(15, 70, 70, 40, 20, 50);
                foreach ($this->items as $item) {
                    $cliente_nombre = "";
                    if ($item->cliente_id != null) {
                        $cliente = cliente::getById($item->cliente_id);
                        if ($cliente != null) $cliente_nombre = $cliente->getTitular()->nombre;
                    }
                    $empleado_nombre = "";
                    if ($item->empleado_id != null) {
                        $empleado = empleado::getById($item->empleado_id);
                        if ($empleado != null) $empleado_nombre = $empleado->nombre;
                        else $empleado_nombre .= 'Desconocido';    
                    }

                    $return["data"][] = array(
                        $item->id_venta,
                        $cliente_nombre,
                        $empleado_nombre,
                        $item->metodo_pago,
                        number_format($item->getTotal(), 2, ",", ".").' €',
                        date("d/m/Y H:i:s", strtotime($item->fecha))
                    );
                }
                break;

            case 'asociados':
                $return["len"] = array(15, 80, 30, 30);
                foreach ($this->items as $item) {
                        $return["data"][] = array(
                        $item->id_asociado,
                        $item->nombre,
                        $item->dni,
                        date("d/m/Y", strtotime($item->fecha))
                    );
                }
                break;
        }

        return $return;
    }
}

//Nos llegará una $_POST con la tabla que debemos mostrar
//Simulamos un post en un variable para poder realizar pruebas
$tabla = $_GET['tabla'];
$download_pdf = (isset($_GET['download_pdf'])) ? TRUE:FALSE;
$download_excel = (isset($_GET['download_excel'])) ? TRUE:FALSE;
//$tabla = "clientes";
//$tabla = "empleados";
//$tabla = "productos";
//$tabla = "ventas";

if (isset($tabla) && $download_pdf == TRUE) {
    $list = new ListController($tabla);
    $pdf = new PdfController();
    $header = $list->headers[$list->tabla];
    array_pop($header);
    $export = $list->toExport();
    $pdf->create($list->name, $header, $export["data"], $export["len"]);
}

if (isset($tabla) && $download_excel == TRUE) {
    $list = new ListController($tabla);
    $excel = new ExcelController();
    $header = $list->headers[$list->tabla];
    array_pop($header);
    $export = $list->toExport();
    $excel->create($list->name, $header, $export["data"]);
}
//Si existe la variable $_POST -> Seguimos para mostrar el HTML
//Si NO existe, no mostramos nada (por defecto el controlador se debe ejecutar siempre)
//Creamos una instancia de ListController -> new ListController();
//Añadimos el HTML genérico -> Añadiendo con php
//1) Nombre de la página (definido previamente en el controlador) -> $this->name
//2) HTML parcial de la cabecera de la tabla -> getHeaders();
//3) HTML parcial con las filas de la tabla -> getRows();
if (isset($tabla)) {
    $list = new ListController($tabla);

    echo '<!DOCTYPE html>
            <html lang="es">
                <head>
                    <meta charset="UTF-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1" />
                    <title>'.$list->name.'</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
                </head>
                <body class="bg-light">

                <div class="container mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Título -->
                        <h2 class="mb-0 flex-grow-1">'.$list->name.'</h2>

                        <!-- Botones e íconos alineados a la derecha -->
                        <div class="d-flex align-items-center gap-2">
                            <!-- Botón Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle d-flex align-items-center gap-1" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-list"></i>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-arrow-down" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M7.646 10.854a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 9.293V5.5a.5.5 0 0 0-1 0v3.793L6.354 8.146a.5.5 0 1 0-.708.708z"/>
                                        <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                                    </svg>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" target="_blank" href="ListController.php?download_excel=true&tabla='.$list->tabla.'">Excel</a></li>
                                    <li><a class="dropdown-item" target="_blank" href="ListController.php?download_pdf=true&tabla='.$list->tabla.'">PDF</a></li>
                                </ul>
                            </div>

                            <!-- Botón Home -->
                            <a href="DsbController.php" class="btn btn-success d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                                    <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                                </svg>
                            </a>

                            <!-- Botón Agregar -->
                            '.$list->getLinkNew().'
                        </div>
                    </div>

                    <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                        '.$list->getHeaders().'
                        </thead>
                        <tbody id="tabla-clientes">
                        '.$list->getRows().'
                        </tbody>
                    </table>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            </body>
        </html>';
}

?>