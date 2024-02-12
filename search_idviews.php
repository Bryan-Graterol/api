<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Datos del Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include './includes/navbar.php'?>
    <?php include './includes/get_user_data.php'; ?>
    <?php
        if (isset($_GET['success'])) {
            if ($_GET['success'] === 'true') {
                echo "<div class='alert alert-success' role='alert'>Editado correctamente.</div>";
            } elseif ($_GET['success'] === 'false') {
                echo "<div class='alert alert-danger' role='alert'>Error al editar.</div>";
            }
        }
    ?> 
    <form method="post" class="w-50 mx-auto mt- p-4 border rounded" id="formSearch" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="id_value" class="form-label">Nombre de Usuario:</label>
        <input type="text" class="form-control mb-3" id="id_value" name="username" placeholder="Ingrese el Nombre de Usuario" required>
        <input type="submit" class="btn btn-primary" value="Consultar Datos">
    </form>
    <?php 
        if (!empty($user_data)) {
            echo '<h2 class="text-center mt-4">Datos de los Usuarios</h2>';
            echo '<table class="table table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Username</th>';
            echo '<th>Password</th>';
            echo '<th>Reseller Notes</th>';
            echo '<th>Max Connections</th>';
            echo '<th>Plan</th>';
            echo '<th>Eliminar</th>';
            echo '<th>Editar</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($user_data as $user) {
                echo '<tr>';
                echo '<td>'. htmlspecialchars($user['id'] ?? 'No hay información disponible') . '</td>';
                echo '<td>'. htmlspecialchars($user['username'] ?? 'No hay información disponible') . '</td>';
                echo '<td>'. htmlspecialchars($user['password'] ?? 'No hay información disponible') . '</td>';
                echo '<td>'. htmlspecialchars($user['reseller_notes'] ?? 'No hay información disponible') . '</td>';
                echo '<td>'. htmlspecialchars($user['max_connections'] ?? 'No hay información disponible') . '</td>';
                echo '<td>';
                // Mostrar los planes seleccionados
                if (!empty($user['bouquet'])) {
                    $plans = json_decode($user['bouquet']);
                    $plan_text = '';
                    foreach ($plans as $plan) {
                        if ($plan == '1') {
                            $plan_text = 'Parrilla Completa';
                        } elseif ($plan == '2') {  
                            $plan_text = 'Solo Nacionales';
                        }
                    }
                    echo $plan_text;
                } else {
                    echo "No tiene";
                }
                echo '</td>';
                echo '<td>
                        <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                            <input type="hidden" name="delete_id" value="' . htmlspecialchars($user['id']) . '">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>';
                echo '<td>
                        <form method="get" action="./edit_userLogic.php">
                            <input type="hidden" name="id" value="' . htmlspecialchars($user['id']) . '">
                            <button type="submit" class="btn btn-danger">Editar</button>
                        </form>
                    </td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
