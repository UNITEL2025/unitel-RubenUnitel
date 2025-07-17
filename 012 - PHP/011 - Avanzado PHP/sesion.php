<?php
    // Inicio de la sesión
    session_start();
?>
<!DOCTYPE html>
<html>
    <body>

    <?php
        //Guardar las variables en la sesión
        // Seteamos las variables de la sesión
        $_SESSION["favcolor"] = "green";
        $_SESSION["favanimal"] = "cat";
        echo "<br>Session variables are set.";
    ?>

    <?php
        //Recuperar las variables de la sesión
        // Echo session variables that were set on previous page
        echo "<br>Favorite color is " . $_SESSION["favcolor"] . ".<br>";
        echo "<br>Favorite animal is " . $_SESSION["favanimal"] . ".";
    ?>

    <?php
        //Destruir sesión (eliminar)
        // Elimina sólo las variables de la sesión
        session_unset();

        // Elimina la sesión en sí
        //Confirmamos si la destrucción ha tenido éxito
        if (session_destroy() == true)
        {
            echo "<br>Sesión destruida!";
        }
        else
        {
            echo "<br>Error al destruir la sesión.";
        }
    ?>

    </body>
</html>