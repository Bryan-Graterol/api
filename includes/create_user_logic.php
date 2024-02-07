<?php
// API key
$api_key = "C46B07DD21675C0AAC4FEFE100F49168";

// Verifica si se ha enviado un formulario POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si se han enviado todos los campos necesarios
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['max_connections'])  && isset($_POST['reseller_notes'])) {
        // Captura los valores de los campos
        $username = $_POST['username'];
        $password = $_POST['password'];
        $max_connections = $_POST['max_connections'];
        $contact = isset($_POST['contact']) ? $_POST['contact'] : "";
        $reseller_notes = isset($_POST['reseller_notes']) ? $_POST['reseller_notes'] : "";

        // URL de la API con los datos directamente en la URL
        $url = 'http://172.16.18.20/APIsomos/?api_key='.$api_key.'&action=create_line&username='.$username.'&password='.$password.'&max_connections='.$max_connections.'&bouquets_selected[]=1&bouquets_selected[]=2&bouquets_selected[]=3&access_output[]=1&access_output[]=2&access_output[]=3'.'&contact='.$contact.'&reseller_notes='.$reseller_notes;

        // Realiza la solicitud a la API
        $response = file_get_contents($url);

        // Verifica si la creación fue exitosa
        if ($response !== false) {
            // Decodifica la respuesta JSON
            $data = json_decode($response, true);

            // Verifica si la solicitud fue exitosa
            if ($data['status'] === 'STATUS_SUCCESS') {
                $success_message = "Usuario creado exitosamente.";
            } else {
                // Si la solicitud no fue exitosa, muestra un mensaje de error
                $error_message = 'Error:Usuario existente.';
            }
        } else {
            // Si hubo un error en la solicitud
            $error_message = 'Error: No se pudo obtener una respuesta de la API.';
        }
    } else {
        // Si no se han enviado todos los campos necesarios, muestra un mensaje de error
        $error_message = "Por favor, complete todos los campos.";
    }
}
?>

<!-- Formulario HTML -->
<form id="add" class="container" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <!-- Div para mostrar mensajes de error y éxito -->
    <?php if (!empty($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            Error: <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success_message)) : ?>
        <div class="alert alert-success" role="alert">
            Enviado: <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <label for="username" class="form-label">Username:</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Ingrese el Nombre de Usuario" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="text" class="form-control" id="password" name="password" placeholder="Ingrese la Contraseña" required>
    </div>

    <div class="mb-3">
        <label for="max_connections" class="form-label">Max Connections:</label>
        <input type="text" class="form-control" id="max_connections" name="max_connections" placeholder="Ingrese el Número Máximo de Conexiones" required>
    </div>

    <div class="mb-3">
        <label for="contact" class="form-label">Contact:</label>
        <input type="text" class="form-control" id="contact" name="contact" placeholder="Ingrese el Contacto">
    </div>

    <div class="mb-3">
        <label for="reseller_notes" class="form-label">Reseller Notes:</label>
        <input type="text" class="form-control" id="reseller_notes" name="reseller_notes" placeholder="Ingrese Notas del Revendedor">
    </div>

    <button type="submit" class="btn btn-primary">Crear Usuario</button>
</form>