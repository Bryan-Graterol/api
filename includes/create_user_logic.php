<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Creación de Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<?php
// API key
$api_key = "C46B07DD21675C0AAC4FEFE100F49168";

// Verifica si se ha enviado un formulario POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si se han enviado todos los campos necesarios
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['reseller_notes'])) {
        // Captura los valores de los campos
        $username = strtolower($_POST['username']);
        $password = $_POST['password'];
        $contact = isset($_POST['contact']) ? $_POST['contact'] : "";
        $reseller_notes = isset($_POST['reseller_notes']) ? $_POST['reseller_notes'] : "";

        // Obtener los valores seleccionados de los planes
        $selected_plan = "";

        // Verificar si se ha seleccionado el Plan 1
        if (isset($_POST['plan'])) {
            $selected_plan = $_POST['plan'];
        }

        // Construir el parámetro bouquets_selected
        $bouquets_selected_param = 'bouquets_selected=' . urlencode(json_encode([$selected_plan]));

        // Construir la URL completa con el parámetro bouquets_selected
        $url = 'http://172.16.18.20/APIsomos/?api_key=' . $api_key . '&action=create_line&username=' . $username . '&password=' . $password . '&max_connections=5&' . $bouquets_selected_param . '&access_output[]=1&access_output[]=2&access_output[]=3&contact=' . $contact . '&reseller_notes=' . $reseller_notes;

        // Realiza la solicitud a la API
        $response = file_get_contents($url);

        if ($response !== false) {
            // Decodifica la respuesta JSON
            $data = json_decode($response, true);
        
            // Verifica si la solicitud fue exitosa
            if ($data['status'] === 'STATUS_SUCCESS') {
                // Accede a los datos solo si la solicitud fue exitosa
                $new_user = array(
                    "id" => isset($data['data']['id']) ? $data['data']['id'] : null,
                    "username" => isset($data['data']['username']) ? $data['data']['username'] : null
                );
        
                // Leer el archivo JSON actual
                $existing_data = file_exists('./users.json') ? json_decode(file_get_contents('./users.json'), true) : array();
        
                // Agregar el nuevo usuario a los datos existentes
                $existing_data[] = $new_user;
        
                // Convertir el array actualizado en formato JSON
                $json_data = json_encode($existing_data);
        
                // Guardar el JSON actualizado en el archivo
                file_put_contents('users.json', $json_data);
        
                // Define el mensaje de éxito
                $success_message = "Usuario creado exitosamente.";
            } else {
                // Si la solicitud no fue exitosa, muestra un mensaje de error
                $error_message = 'Error: El usuario ya existe';
            }
        } else {
            // Si hubo un error en la solicitud
            $error_message = 'Error: No se pudo obtener una respuesta.';
        }
        } else {
            // Si hubo un error en la solicitud
            $error_message = 'Error: No se pudo obtener una respuesta.';
        }
    } else {
        // Si no se han enviado todos los campos necesarios, muestra un mensaje de error
        $error_message = "Por favor, complete todos los campos.";
    }
?>

<div class="container">
    <!-- Formulario HTML -->
    <form id="add" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
            <input type="text" class="form-control" id="password" name="password" placeholder="Ejemplo:17498237" required>
            <?php echo "<h6>En la password debe ir la cedula</h6>" ?>
        </div>

        <div class="mb-3 ">
        <br>
            <input type="radio" id="plan1" name="plan" value="1" required>
            <label for="plan1"> Parrilla completa</label><br>
            <input type="radio" id="plan2" name="plan" value="2">
            <label for="plan2"> Solo nacionales</label><br>
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
</div>

</body>
</html>
