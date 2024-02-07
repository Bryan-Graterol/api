<?php
// conexionBD.php

/*
$host = "10.0.2.4";
$user = "root";
$password = "S0m0s2023*-";
$database = "testradius";
*/

$host = "10.0.2.4";
$user = "root2";
$password = "S0m0s2023*-";
$database = "testradius";


$conexion = mysqli_connect($host, $user, $password, $database);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
    echo"Error de conexion";
}


?>