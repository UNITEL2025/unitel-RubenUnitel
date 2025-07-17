<?php
# http://localhost/repo/unitel-RubenUnitel/012%20-%20PHP/011%20-%20Avanzado%20PHP/filtros.php

//FILTROS
//Sirven para validar datos

//IP
//$ip = "127.0.0.1"; //Localhost

function checkIp($ip)
{
    if (!filter_var($ip, FILTER_VALIDATE_IP) === false) {
    echo("<br>$ip is a valid IP address");
    } else {
    echo("<br>$ip is not a valid IP address");
    }
}

checkIp("127.0.0.1");
checkIp("500.0.0.1");

function checkEmail($email) {
    // Limpiar email de caracteres fakes
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Validate e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    echo("<br>$email is a valid email address");
    } else {
    echo("<br>$email is not a valid email address");
    }
}

checkEmail("john.doe@example.com");
checkEmail("john.doe@example");
checkEmail("john.doe@example.com$");