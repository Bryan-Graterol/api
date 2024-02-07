<title>Consulta de Datos de Usuarios</title>
<style>
table {
    border-collapse: collapse;
    width: 80%;
    margin: 20px auto;
}

th,
td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}
</style>
<?php
// Función para realizar una solicitud a la API
function makeRequest($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

// Endpoint para obtener el número total de registros
$endpoint = 'http://172.16.18.20/APIsomos/?api_key=C46B07DD21675C0AAC4FEFE100F49168&action=get_lines';
$response = makeRequest($endpoint);

// Verifica si la respuesta es válida
if ($response !== false) {
    // Decodifica la respuesta JSON
    $data = json_decode($response, true);

    // Verifica si la solicitud fue exitosa
    if ($data['status'] === 'STATUS_SUCCESS') {
        // Extrae el valor de "recordsTotal" y le suma 57
        $total_records = intval($data['recordsTotal']) + 100;
        #echo $total_records;
        // Número de registros por página
        $records_per_page = 50;

        // Número total de páginas
        $total_pages = ceil($total_records / $records_per_page);

        // Página actual
        $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        // Calcular el índice inicial y final de los registros de la página actual
        $start_index = ($current_page - 1) * $records_per_page + 1;
        $end_index = min($start_index + $records_per_page - 1, $total_records);

        // Imprime el título de la tabla y el estilo CSS
        echo '<title>Consulta de Datos de Usuarios</title>';
        echo '<style>table {border-collapse: collapse;width: 80%;margin: 20px auto;}th,td {border: 1px solid #ddd;padding: 8px;text-align: left;}th {background-color: #f2f2f2;}.pagination {display: flex; justify-content: center;}.pagination a {color: black; float: left; padding: 8px 16px; text-decoration: none; transition: background-color .3s;border: 1px solid #ddd;}.pagination a.active {background-color: #007bff; color: white; border: 1px solid #007bff;}.pagination a:hover:not(.active) {background-color: #ddd;}</style>';
        echo '<table><tr><th>ID</th><th>Username</th><th>Password</th><th>Reseller Notes</th><th>Max Connections</th></tr>';

        // API key
        $api_key = "C46B07DD21675C0AAC4FEFE100F49168";

        // Función para obtener datos del usuario por ID
        function getLine($api_key, $id) {
            $url = 'http://172.16.18.20/APIsomos/?api_key=' . $api_key . '&action=get_line&id=' . $id;
            return makeRequest($url);
        }

        // Iterar sobre los registros de la página actual
        for ($id = $start_index; $id <= $end_index; $id++) {
            // Ejecutar la función para obtener datos del usuario
            $response = getLine($api_key, $id);

            // Verificar si la respuesta es válida
            if ($response !== false) {
                // Decodificar la respuesta JSON
                $data = json_decode($response, true);

                // Verificar si la solicitud fue exitosa
                if ($data['status'] === 'STATUS_SUCCESS') {
                    // Extraer los datos necesarios
                    $user_data = $data['data'];
                    // Imprimir fila de la tabla con los datos del usuario
                    echo '<tr><td>' . htmlspecialchars($user_data['id']) . '</td><td>' . (isset($user_data['username']) ? htmlspecialchars($user_data['username']) : "No tiene información") . '</td><td>' . (isset($user_data['password']) ? htmlspecialchars($user_data['password']) : "No tiene información") . '</td><td>' . (isset($user_data['reseller_notes']) ? htmlspecialchars($user_data['reseller_notes']) : "No tiene información") . '</td><td>' . (isset($user_data['max_connections']) ? htmlspecialchars($user_data['max_connections']) : "No tiene información") . '</td></tr>';
                }
            }
        }

        // Cierra la tabla
        echo '</table>';

        // Imprimir la paginación con Bootstrap
        echo '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
        for ($page = 1; $page <= $total_pages; $page++) {
            echo '<li class="page-item ' . ($page == $current_page ? 'active' : '') . '"><a class="page-link" href="?page=' . $page . '">' . $page . '</a></li>';
        }
        echo '</ul></nav>';
    } else {
        // Si la solicitud no fue exitosa, muestra un mensaje de error
        echo '<div class="text-center mt-4">Error: La solicitud a la API no fue exitosa.</div>';
    }
} else {
    // Si hubo un error en la solicitud
    echo '<div class="text-center mt-4">Error de cURL: No se pudo obtener una respuesta de la API.</div>';
}
?>
