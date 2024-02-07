<?php
// API key
$api_key = "C46B07DD21675C0AAC4FEFE100F49168";

// Función para hacer la solicitud a la API
function makeRequest($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    if ($response === false) {
        // Manejar el error de cURL
        $error_message = 'Error de cURL: ' . curl_error($curl);
        // Puedes redirigir a una página de error o mostrar un mensaje al usuario
        exit($error_message);
    }
    curl_close($curl);
    return $response;
}

// Función para obtener los datos del usuario
function getUserData($api_key, $id) {
    $url = 'http://172.16.18.20/APIsomos/?api_key=' . $api_key . '&action=get_line&id=' . $id;
    return makeRequest($url);
}

// Función para actualizar los datos del usuario
function updateUserData($api_key, $id, $username, $password, $max_connections, $contact,$reseller_notes) {
    $url = 'http://172.16.18.20/APIsomos/?api_key=' . $api_key . '&action=edit_line&id=' . $id;
    // Datos a enviar en la solicitud POST
    $data = array(
        'username' => $username,
        'password' => $password,
        'max_connections' => $max_connections,
        'reseller_notes' => $reseller_notes,
        'contact' => $contact,
        'bouquets_selected' => array("1", "2", "3"), // Ajusta según tus necesidades
        'access_output' => array("1", "2", "3") // Ajusta según tus necesidades
    );
    // Inicializar cURL
    $curl = curl_init();
    // Configurar opciones de cURL
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // Ejecutar la solicitud y obtener la respuesta
    $response = curl_exec($curl);
    if ($response === false) {
        // Manejar el error de cURL
        $error_message = 'Error de cURL: ' . curl_error($curl);
        // Puedes redirigir a una página de error o mostrar un mensaje al usuario
        exit($error_message);
    }
    curl_close($curl);
    return $response;
}

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($id) {
        // Capturar los datos del formulario
        $username = $_POST['username'];
        $password = $_POST['password'];
        $max_connections = $_POST['max_connections'];
        $contact = $_POST['contact'];
        $reseller_notes = $_POST['reseller_notes'];

        // Actualizar los datos del usuario
        $response = updateUserData($api_key, $id, $username, $password, $max_connections, $contact, $reseller_notes);

        // Verificar la respuesta de la API
        $data = json_decode($response, true);
        if ($data && $data['status'] === 'STATUS_SUCCESS') {
            // Mensaje de edición completa
            $success_message = "Usuario editado exitosamente.";
        } else {
            // Mensaje de edición errónea
            $error_message = 'Error: La solicitud no fue exitosa.';
        }
    } else {
        $error_message = "Error: No se proporcionó un ID de usuario.";
    }
} elseif ($id) {
    // Obtener los datos del usuario
    $userData = getUserData($api_key, $id);
    $user = json_decode($userData, true);
    if ($user && $user['status'] === 'STATUS_SUCCESS') {
        $username = isset($user['data']['username']) ? $user['data']['username'] : '';
        $password = isset($user['data']['password']) ? $user['data']['password'] : '';
        $max_connections = isset($user['data']['max_connections']) ? $user['data']['max_connections'] : '';
        $reseller_notes = isset($user['data']['reseller_notes']) ? $user['data']['reseller_notes'] : '';
        $contact = isset($user['data']['contact']) ? $user['data']['contact'] : '';
    } else {
        $error_message = 'Error: No se pudo obtener la información del usuario.';
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
        <?php if (!empty($success_message)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <?php if ($id && empty($error_message)) : ?>
            <form id="edit" method="post" action="">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="text" class="form-control" id="password" name="password" value="<?php echo $password; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="max_connections" class="form-label">Max Connections:</label>
                    <input type="text" class="form-control" id="max_connections" name="max_connections" value="<?php echo $max_connections; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="reseller_notes" class="form-label">Reseller_notes:</label>
                    <input type="text" class="form-control" id="reseller_notes" name="reseller_notes" value="<?php echo $reseller_notes; ?>">
                </div>
                <div class="mb-3">
                    <label for="contact" class="form-label">Contact:</label>
                    <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $contact; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Editar Usuario</button>
            </form>
        <?php else : ?>
            <div class="alert alert-danger" role="alert">
                No se proporcionó un ID válido o no se pudo obtener la información del usuario.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
