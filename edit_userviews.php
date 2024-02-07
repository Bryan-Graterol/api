<?php
// API key
$api_key = "C46B07DD21675C0AAC4FEFE100F49168";

// Verifica si se ha enviado un formulario POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si se ha enviado el ID del usuario a editar
    if (isset($_POST['id'])) {
        // Redirige a la página de edición con el ID del usuario
        header("Location: ./edit_userLogic.php?id=" . $_POST['id']);
        exit;
    } else {
        // Si no se envió el ID, muestra un mensaje de error
        $error_message = "Error: No se proporcionó un ID de usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <?php include './includes/navbar.php' ?>
    <div class="container">
        <h1 class="mt-5">Editar Usuario</h1>

        <?php if (!empty($error_message)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form id="edit" method="post" action="">
            <div class="mb-3">
                <label for="id" class="form-label">ID del Usuario:</label>
                <input type="text" class="form-control" id="id" name="id" required>
            </div>

            <button type="submit" class="btn btn-primary">Editar Usuario</button>
        </form>
    </div>
</body>

</html>
