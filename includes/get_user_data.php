<?php
// API key
$api_key = "C46B07DD21675C0AAC4FEFE100F49168";

// Función para realizar una solicitud a la API
function makeRequest($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

// Función para eliminar una línea a través de la API
function deleteLine($api_key, $id) {
    $url = 'http://172.16.18.20/APIsomos/?api_key=' . $api_key . '&action=delete_line&id=' . $id;
    $response = makeRequest($url);
    $data = json_decode($response, true); // Decodificar la respuesta JSON

    if ($data !== null && isset($data['status']) && $data['status'] === 'STATUS_SUCCESS') {
        return true; // La eliminación fue exitosa
    } else {
        return false; // Hubo un error al eliminar
    }
}

// Función para conectar a la base de datos
function connectToDatabase() {
    $host = "172.16.18.20";
    $user = "front";
    $password = "S0m0s2023*-";
    $database = "xui";
    
    // Crear la conexión
    $conn = new mysqli($host, $user, $password, $database);
    
    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    return $conn;
}

// Función para obtener los datos del usuario por nombre de usuario desde la base de datos
function getUserDataFromDatabase($conn, $username) {
    $username = $conn->real_escape_string($username);
    $sql = "SELECT * FROM xui.lines WHERE username LIKE '%$username%' OR password LIKE '%$username%' ";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return array(); // Devuelve un array vacío si no se encuentran resultados
    }
}


// Verifica si se ha enviado un formulario POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username'])) {
        // Captura el valor del nombre de usuario
        $username = strtolower($_POST['username']);

        // Conexión a la base de datos
        $pdo = connectToDatabase();

        // Obtener los datos del usuario de la base de datos
        $user_data = getUserDataFromDatabase($pdo, $username);

        // Verificar si se encontraron los datos del usuario
        if ($user_data !== false) {
            // Imprime los datos del usuario
            //echo '<div class="text-center mt-4">';
            //echo 'ID: ' . htmlspecialchars($user_data['id']) . '<br>';
            //echo 'Username: ' . htmlspecialchars($user_data['username']) . '<br>';
            // Imprime los demás campos necesarios
            //echo '</div>';
        } else {
            // Si el usuario no existe en la base de datos
            echo '<div class="text-center mt-4">Error: El usuario no fue encontrado.</div>';
        }
    }

    if (isset($_POST['delete_id'])) {
        // Ejecuta la función para eliminar la línea
        $delete_id = $_POST['delete_id'];
        $response = deleteLine($api_key, $delete_id);
        if ($response===true) {
            echo "<div class='text-center mt-4'>Se eliminó correctamente.</div>";
        } else {
            echo "<div class='text-center mt-4'>Error al eliminar el usuario.</div>";
        }
    }
}
?>
