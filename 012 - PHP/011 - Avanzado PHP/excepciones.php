<?php

//EXCEPCIONES
//Son errores no controlados (por el programador)
//Paran la ejecución del código
//Se pueden gestionar para evitar la interrupcción del código

//Crear/Lanzar una excepción (para la ejecución del script)
//Función que divide
function divide($dividend, $divisor) {
  if($divisor == 0) {
    throw new Exception("[001] ERROR Division by zero");
  }
  return $dividend / $divisor;
}

echo "<br>".divide(10, 2);
//echo "<br>".divide(10, 0);

//Bloque TRY...CATCH
// try {
//   code that can throw exceptions
// } catch(Exception $e) {
//   code that runs when an exception is caught
// }
try {
  echo "<br>".divide(5, 0);
} catch(Exception $e) {
  echo "<br>Unable to divide.";
}

echo "<br>Sigue la ejecución del código...";

//Bloque TRY...CATCH...FINALLY
// try {
//   code that can throw exceptions
// } catch(Exception $e) {
//   code that runs when an exception is caught
// } finally {
//   code that always runs regardless of whether an exception was caught
// }

try {
  echo divide(5, 0);
} catch(Exception $e) {
  echo "<br>Unable to divide. ";
} finally {
  echo "<br>Process complete.";
}

//Ejemplo de captura de excepción imprimiendo detalles
try {
  echo divide(5, 0);
} catch(Exception $ex) {
  $code = $ex->getCode();
  $message = $ex->getMessage();
  $file = $ex->getFile();
  $line = $ex->getLine();
  echo "<br>Exception thrown in $file on line $line: [Code $code]
  $message";
}