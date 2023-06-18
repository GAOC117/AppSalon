<?php

$db = mysqli_connect('localhost', 'root', 'admin', 'AppSalon');
 // $db = new mysqli('Localhost','root', 's1t3ur@dmin', 'AppSalon');



if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
