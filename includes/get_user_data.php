<?php
// API key
$api_key = "C46B07DD21675C0AAC4FEFE100F49168";

// Función para obtener datos del usuario
function getLine($api_key, $id) {
    $url = 'http://172.16.18.20/APIsomos/?api_key=' . $api_key . '&action=get_line&id=' . $id;
    return makeRequest($url);
}

// Función para eliminar una línea
function deleteLine($api_key, $id) {
    $url = 'http://172.16.18.20/APIsomos/?api_key=' . $api_key . '&action=delete_line&id=' . $id;
    return makeRequest($url);
}

// Verifica si se ha enviado un formulario POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_value'])) {
    // Captura el valor del ID
    $id_value = $_POST['id_value'];

    // Ejecuta la función para obtener datos del usuario
    $response = getLine($api_key, $id_value);

    // Verifica si la respuesta es válida
    if ($response !== false) {
        // Decodifica la respuesta JSON
        $data = json_decode($response, true);

        // Verifica si la solicitud fue exitosa
        if ($data['status'] === 'STATUS_SUCCESS') {
            // Extrae los datos necesarios
            $user_data = $data['data'];

            // Verifica si cada campo tiene datos o no
            $id = isset($user_data['id']) ? htmlspecialchars($user_data['id']) : "No hay datos";
            $username = isset($user_data['username']) ? htmlspecialchars($user_data['username']) : "No hay datos";
            $password = isset($user_data['password']) ? htmlspecialchars($user_data['password']) : "No hay datos";
            $reseller_notes = isset($user_data['reseller_notes']) ? htmlspecialchars($user_data['reseller_notes']) : "No hay datos";
            $max_connections = isset($user_data['max_connections']) ? htmlspecialchars($user_data['max_connections']) : "No hay datos";
        } else {
            // Si la solicitud no fue exitosa, muestra un mensaje de error
            echo '<div class="text-center mt-4">Error: Error no existe el id.</div>';
        }
    } else {
        // Si hubo un error en la solicitud
        echo '<div class="text-center mt-4">Error de cURL: No se pudo obtener una respuesta de la API.</div>';
    }
}

// Verifica si se ha enviado un formulario POST para eliminar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    // Ejecuta la función para eliminar la línea
    $delete_id = $_POST['delete_id'];
    $response = deleteLine($api_key, $delete_id);
    if ($response !== false) {
        echo ($response === 'STATUS_SUCCESS') ? "<div class='text-center mt-4'>Se eliminó correctamente.</div>" : "<div class='text-center mt-4'>No se eliminó la línea.</div>";
    } else {
        echo "<div class='text-center mt-4'>Error de cURL: No se pudo obtener una respuesta de la API al intentar eliminar la línea.</div>";
    }
}

// Función genérica para realizar una solicitud a la API
function makeRequest($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}
?>
