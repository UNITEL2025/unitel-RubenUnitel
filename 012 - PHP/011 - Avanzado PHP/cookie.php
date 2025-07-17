<?php
    //Creamos un nombre de cookie
    $cookie_name = "user";
    //Creamos una variable a la cookie
    //El nombre del usuario
    $cookie_value = "John Doe";
    //Asignamos los datos a la cookie
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

    //Otra cookie
    setcookie("isVisit", "YA HA VISITADO LA PÁGINA", time() + (86400 * 30), "/");
?>

<html>
<body>

    <?php
    //Si NO existe la cookie
    if(!isset($_COOKIE[$cookie_name])) {
        echo "<br>Cookie named '" . $cookie_name . "' is not set!";
    //Si existe => imprimo sus datos
    } else {
        //La variable viene de php
        echo "<br>Cookie '" . $cookie_name . "' is set!<br>";
        //La variable la coge de la cookie
        echo "<br>Value is: " . $_COOKIE[$cookie_name];
    }
    ?>

</body>
</html>