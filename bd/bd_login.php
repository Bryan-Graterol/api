<?php
// conexionBD.php

session_start();
$_SESSION["error_message"] = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    @include("./conexionBD.php");
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Utilizamos una consulta preparada para evitar inyecciones SQL
    $sql = "SELECT id, password, role_id FROM r_users WHERE email=?";
    $stmt = $conexion->prepare($sql);

    // Vincular los parámetros y ejecutar la consulta
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Obtenemos la fila de resultados como un array asociativo
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];

        // Verificar la contraseña directamente (sin encriptar)
        if ($password === $stored_password) {
            // La contraseña es correcta, iniciar sesión y redirigir a otra página
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role_id'] = $row['role_id'];

            // Registrar el inicio de sesión en el registro de logs
            $user_id = $row['id'];
            $timestamp = date("Y-m-d H:i:s");
            $insert_log_query = "INSERT INTO r_logs (user_id, login_time) VALUES (?, ?)";
            $stmt = $conexion->prepare($insert_log_query);
            $stmt->bind_param("ss", $user_id, $timestamp);
            $stmt->execute();

            header("Location: ../board.php");
            exit();
        }
    }

    $_SESSION["error_message"] = "Email o contraseña incorrectos";
    header("Location: ../login.php");
    exit();
}

$conexion->close();
?>
