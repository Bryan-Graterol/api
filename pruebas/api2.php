<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Datos del Usuario</title>
    <style>
        form {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            border-collapse: collapse;
            width: 50%;
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
    <h2>Consulta de Datos del Usuario</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="id_value">ID:</label>
        <input type="text" id="id_value" name="id_value" placeholder="Ingrese el ID" required>
        <input type="submit" value="Consultar Datos">
    </form>

    <?php
    // API key
    $api_key = "C46B07DD21675C0AAC4FEFE100F49168";

    // Verifica si se ha enviado un formulario POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verifica si se ha enviado un valor de ID
        if (isset($_POST['id_value'])) {
            // Captura el valor del ID
            $id_value = $_POST['id_value'];

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
    ?>
    <h2>Datos del Usuario</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Reseller Notes</th>
            <th>Max Connections</th>
            <th>Acciones</th> <!-- Nueva columna para los botones -->
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($user_data['id']); ?></td>
            <td><?php echo htmlspecialchars($user_data['username']); ?></td>
            <td><?php echo htmlspecialchars($user_data['password']); ?></td>
            <td><?php echo htmlspecialchars($user_data['reseller_notes']); ?></td>
            <td><?php echo htmlspecialchars($user_data['max_connections']); ?></td>
            <td>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($user_data['id']); ?>">
                    <input type="submit" value="Eliminar">
                </form>
            </td>
        </tr>
    </table>
    <?php
                } else {
                    // Si la solicitud no fue exitosa, muestra un mensaje de error
                    echo 'Error: La solicitud a la API no fue exitosa.';
                }
            } else {
                // Si hubo un error en la solicitud
                echo 'Error de cURL: No se pudo obtener una respuesta de la API.';
            }
        } else {
            // Si no se ha enviado un valor de ID, muestra un mensaje de error
            echo "No se ha enviado un valor de ID";
        }
    }

    // Verifica si se ha enviado un formulario POST para eliminar
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
        // Ejecuta la función para eliminar la línea
        $delete_id = $_POST['delete_id'];
        $response = deleteLine($api_key, $delete_id);
        echo "<p>Resultado de la eliminación: $response</p>";
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
</body>
</html>
