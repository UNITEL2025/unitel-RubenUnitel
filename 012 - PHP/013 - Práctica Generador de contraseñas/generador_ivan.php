<?php
$checked = array(
    'BAJA' => "",
    'MEDIA' => "",
    'ALTA' => ""
);

$contraseña = '';
$seguridad = '';
$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$str_mi = "abcdefghijklmnopqrstuvwxyz";
$str_sim = "!@#$%^&*()-_=+[]{}<>?/";

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['seguridad'])) {
    // Obtener el valor del input 'seguridad'
    $seguridad = $_POST['seguridad'];
    $checked[$seguridad] = "checked";
}
else{
    $checked["BAJA"] = "checked";
}



switch ($seguridad) { //condicion por la que se filtran los casos
  case "BAJA": //no cumple la condicion, no se ejecuta
    $contraseña = rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9);
    break;
    case "MEDIA": //no cumple la condicion, no se ejecuta
    $pos = rand(0, strlen($str));
    $letra = substr($str, $pos, 1 );
    $contraseña = rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).$letra;
    break;
  case "ALTA": //no cumple la condicion, no se ejecuta
    //4 digitos una letra mayus una minus y un simbolo
    $pos = rand(0, strlen($str));
    $pos2 = rand(0, strlen($str_mi));
    $pos3 = rand(0, strlen($str_sim));
    $letraMay = substr($str, $pos, 1 );
    $letraMin = substr($str_mi, $pos2, 1);
    $simbol = substr($str_sim, $pos3, 1);
    $contraseña = rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).$letraMay.$letraMin.$simbol;
    break;
  default: //al no cumplir la condicion en ninguno de los casos
  //se ejecuta el bloque default y se acaba el switch
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Generador contraseñas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="../assets/js/color-modes.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 style="text-align: center; background-color: aqua;">GENERADOR DE CONTRASEÑAS</h1>
                <div class="row">
                    <div class="col-3">
                        <div class="d-flex">
                            <form action="generador_ivan.php" method="POST">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="seguridad" id="seguridad1" value="BAJA" <?php echo $checked["BAJA"]; ?>
                                    >
                                    <label class="form-check-label" for="radioDefault1">
                                        BAJA
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="seguridad" id="seguridad2" value="MEDIA" <?php echo $checked["MEDIA"]; ?>
                                        >
                                    <label class="form-check-label" for="radioDefault2">
                                        MEDIA
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="seguridad" id="seguridad3" value="ALTA" <?php echo $checked["ALTA"]; ?>
                                        >
                                    <label class="form-check-label" for="radioDefault2">
                                        ALTA
                                    </label>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label"></label>
                                    <input type="pswd" class="form-control" id="contraseña" placeholder="" name="contraseña" value="<?php echo $contraseña;?>"> 
                                        
                                    <button type="submit" class="btn btn-secondary">Enviar</button>
                                    <button type="button" class="btn btn-secondary">
                                        <a href="#" onclick="copyPassword()" >
                                        <i class="fa-regular fa-clipboard"></i></a>
                                    </button>
                                    
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    
    <script> function copyPassword() {
                const input = document.getElementById("contraseña");
                input.select();
                input.setSelectionRange(0, 99999);
                document.execCommand("copy");
                alert("¡Contraseña copiada!");
            }
    </script>     


</body>
<footer>

</footer>

</html>