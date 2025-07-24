<?php
// Inicializamos expresión vacía y resultado vacío
$expresion = '';
$resultado = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recogemos expresión actual y el botón pulsado
    $expresion = $_POST['expresion'] ?? ''; //ej. 8
    $boton = $_POST['boton'] ?? ''; //ej +

    // Si botón es "C" limpiamos expresión
    if ($boton === 'C') {
        $expresion = '';
        $resultado = '';
    } 
    // Si botón es "=" evaluamos expresión
    else if ($boton === '=') {
        // Limpiamos expresión para seguridad básica
        $expresion_limpia = preg_replace('/[^0-9+\-.*\/()% ]/', '', $expresion);

        try {
            $resultado = eval('return ' . $expresion_limpia . ';');
        } catch (Throwable $e) {
            $resultado = 'Error en expresión';
        }
    } 
    // Si es cualquier otro botón, agregamos el carácter a la expresión
    else {
        // Reemplazar símbolos especiales por operadores PHP
        $map = [
            '÷' => '/',
            '×' => '*',
            '−' => '-',
        ];
        $boton_valor = $map[$boton] ?? $boton;

        $expresion .= $boton_valor; //ej "8*"
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Calculadora Básica</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card p-4 shadow" style="width: 320px;">
    <form method="POST" action="">
      <!-- Display para mostrar la expresión -->
      <input type="text" class="form-control form-control-lg mb-3 text-end" 
             readonly name="expresion" value="<?= htmlspecialchars($expresion) ?>" />

      <!-- Mostrar resultado si existe -->
      <?php if ($resultado !== ''): ?>
      <input type="text" class="form-control form-control-lg mb-3 text-end text-success" 
             readonly value="<?= htmlspecialchars($resultado) ?>" />
      <?php endif; ?>

      <div class="row g-2">
        <!-- Botones: cada uno envía el valor en name="boton" -->
        <div class="col-3"><button type="submit" name="boton" value="C" class="btn btn-danger w-100">C</button></div>
        <div class="col-3"><button type="submit" name="boton" value="(" class="btn btn-secondary w-100">(</button></div>
        <div class="col-3"><button type="submit" name="boton" value=")" class="btn btn-secondary w-100">)</button></div>
        <div class="col-3"><button type="submit" name="boton" value="÷" class="btn btn-warning w-100">÷</button></div>

        <div class="col-3"><button type="submit" name="boton" value="7" class="btn btn-light w-100">7</button></div>
        <div class="col-3"><button type="submit" name="boton" value="8" class="btn btn-light w-100">8</button></div>
        <div class="col-3"><button type="submit" name="boton" value="9" class="btn btn-light w-100">9</button></div>
        <div class="col-3"><button type="submit" name="boton" value="×" class="btn btn-warning w-100">×</button></div>

        <div class="col-3"><button type="submit" name="boton" value="4" class="btn btn-light w-100">4</button></div>
        <div class="col-3"><button type="submit" name="boton" value="5" class="btn btn-light w-100">5</button></div>
        <div class="col-3"><button type="submit" name="boton" value="6" class="btn btn-light w-100">6</button></div>
        <div class="col-3"><button type="submit" name="boton" value="−" class="btn btn-warning w-100">−</button></div>

        <div class="col-3"><button type="submit" name="boton" value="1" class="btn btn-light w-100">1</button></div>
        <div class="col-3"><button type="submit" name="boton" value="2" class="btn btn-light w-100">2</button></div>
        <div class="col-3"><button type="submit" name="boton" value="3" class="btn btn-light w-100">3</button></div>
        <div class="col-3"><button type="submit" name="boton" value="+" class="btn btn-warning w-100">+</button></div>

        <div class="col-6"><button type="submit" name="boton" value="0" class="btn btn-light w-100">0</button></div>
        <div class="col-3"><button type="submit" name="boton" value="." class="btn btn-light w-100">.</button></div>
        <div class="col-3"><button type="submit" name="boton" value="=" class="btn btn-success w-100">=</button></div>
      </div>
    </form>
  </div>
</div>

</body>
</html>
