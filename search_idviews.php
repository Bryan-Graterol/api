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
    
    <form method="post" class="w-50 mx-auto p-4 border rounded" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="id_value" class="form-label">ID:</label>
        <input type="text" class="form-control mb-3" id="id_value" name="id_value" placeholder="Ingrese el ID" required>
        <input type="submit" class="btn btn-primary" value="Consultar Datos">
    </form>

    <?php if (!empty($user_data)): ?>
        <h2 class="text-center mt-4">Datos del Usuario</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Reseller Notes</th>
                    <th>Max Connections</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo htmlspecialchars($user_data['id']) ?? ''; ?></td>
                    <td><?php echo htmlspecialchars($user_data['username']) ?? ''; ?></td>
                    <td><?php echo htmlspecialchars($user_data['password']) ?? '' ; ?></td>
                    <td><?php echo htmlspecialchars($user_data['reseller_notes']?? ''); ?></td>
                    <td><?php echo htmlspecialchars($user_data['max_connections']?? ''); ?></td>
                    <td>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($user_data['id']); ?>">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
