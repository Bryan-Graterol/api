<?php
// conexionBD.php

/*
$host = "10.0.2.4";
$user = "root";
$password = "S0m0s2023*-";
$database = "testradius";
*/

$host = "172.16.18.20";
$user = "front";
$password = "S0m0s2023*-";
$database = "xui";


$conexion = mysqli_connect($host, $user, $password, $database);

if (!$conexion) {
    echo "error";
    exit;
}else {
    echo "yes";
    mysqli_close($conexion);
}

