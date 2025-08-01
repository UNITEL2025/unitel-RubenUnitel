<?php

require "controller_bd.php";

//Obtener y transformar en integer el valor de la variable q
if (isset($_GET['q'])) $q = $_GET['q'];
else $q = "";

$salida = array(
    "status" => 0, //0 => Error BBDD, 1 => OK, 2 => Sin resultados
    "html" => ""
);

//Obtener la conexión
$conn = bd::getConn();
//TODO que la conexión correcta

//Obtenemos la consulta
try {
    $stmt = $conn->prepare("SELECT * FROM tbfaq WHERE titulo LIKE '%".$q."%' OR texto LIKE '%".$q."%';");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $items = $stmt->fetchAll();
} catch(PDOException $e) {
    $salida["status"] = 0;
}

//Comprobar si tenemos resultado
if (empty($items)) {
    //Mostrar el mensaje de info
    $salida["status"] = 2;
}
else {
    $salida["status"] = 1; //Correcto
    $salida["html"] = '<div class="accordion mb-4" id="faqAccordion">';

    for ($i=0; $i < count($items); $i++) { 
        //Apertura del contenedor del acordeón
        
        //Item del acordeón
        $salida["html"] .= '<div class="accordion-item">
                <h2 class="accordion-header" id="heading'.$i.'">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$i.'"
                        aria-expanded="true" aria-controls="collapse'.$i.'">
                        '.$items[$i]["titulo"].'
                    </button>
                </h2>
                <div id="collapse'.$i.'" class="accordion-collapse collapse" aria-labelledby="heading'.$i.'"
                    data-bs-parent="#faqAccordion'.$i.'">
                    <div class="accordion-body">
                        '.$items[$i]["texto"].'
                    </div>
                </div>
            </div>';
        
    }
    //Cierre del contenedor del acordeón
    $salida["html"] .= '</div>';
}
echo json_encode($salida);
?>