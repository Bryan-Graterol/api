<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Datos de Usuarios</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Consulta de Datos de Usuarios</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Reseller Notes</th>
            <th>Max Connections</th>
        </tr>
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

        // API key
        $api_key = "C46B07DD21675C0AAC4FEFE100F49168";

        // Función para obtener datos del usuario por ID
        function getLine($api_key, $id) {
            $url = 'http://172.16.18.20/APIsomos/?api_key=' . $api_key . '&action=get_line&id=' . $id;
            return makeRequest($url);
        }

        // Iterar desde el ID 1 hasta el ID 715
        for ($id = 1; $id <= 715; $id++) {
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
        ?>
        <tr>
            <td><?php echo htmlspecialchars($user_data['id']); ?></td>
            <td><?php echo isset($user_data['username']) ? htmlspecialchars($user_data['username']) : "No tiene información"; ?></td>
            <td><?php echo isset($user_data['password']) ? htmlspecialchars($user_data['password']) : "No tiene información"; ?></td>
            <td><?php echo isset($user_data['reseller_notes']) ? htmlspecialchars($user_data['reseller_notes']) : "No tiene información"; ?></td>
            <td><?php echo isset($user_data['max_connections']) ? htmlspecialchars($user_data['max_connections']) : "No tiene información"; ?></td>
        </tr>
        <?php
                }
            }
        }
        ?>
    </table>
</body>
</html>
