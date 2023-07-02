<?php

$db = mysqli_connect('localhost', 'root', 'admin', 'appsalon_mvc');
 // $db = new mysqli('Localhost','root', 's1t3ur@dmin', 'appsalon_mvc');



if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
