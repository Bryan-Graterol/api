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
        input[type="checkbox"] {
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
    </style>
</head>
<body>
    <h2>Crear Nuevo Usuario</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Ingrese el Nombre de Usuario" required><br>

        <label for="password">Password:</label>
        <input type="text" id="password" name="password" placeholder="Ingrese la Contraseña" required><br>

        <label for="max_connections">Max Connections:</label>
        <input type="text" id="max_connections" name="max_connections" placeholder="Ingrese el Número Máximo de Conexiones" required><br>

        <label for="bouquets">Bouquets:</label><br>
        <input type="checkbox" id="bouquets1" name="bouquets[]" value="1">
        <label for="bouquets1">Bouquet 1</label><br>
        <input type="checkbox" id="bouquets2" name="bouquets[]" value="2">
        <label for="bouquets2">Bouquet 2</label><br>
        <input type="checkbox" id="bouquets3" name="bouquets[]" value="3">
        <label for="bouquets3">Bouquet 3</label><br>

        <label for="access_outputs">Access Outputs:</label><br>
        <input type="checkbox" id="access_output1" name="access_output[]" value="1">
        <label for="access_output1">Output 1</label><br>
        <input type="checkbox" id="access_output2" name="access_output[]" value="2">
        <label for="access_output2">Output 2</label><br>
        <input type="checkbox" id="access_output3" name="access_output[]" value="3">
        <label for="access_output3">Output 3</label><br>

        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" placeholder="Ingrese el Contacto"><br>

        <label for="reseller_notes">Reseller Notes:</label>
        <input type="text" id="reseller_notes" name="reseller_notes" placeholder="Ingrese Notas del Revendedor"><br>

        <input type="submit" value="Crear Usuario">
    </form>

    <?php
    // API key
    $api_key = "C46B07DD21675C0AAC4FEFE100F49168";

    // Verifica si se ha enviado un formulario POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verifica si se han enviado todos los campos necesarios
        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['max_connections']) && isset($_POST['bouquets']) && isset($_POST['access_output'])) {
            // Captura los valores de los campos
            $username = $_POST['username'];
            $password = $_POST['password'];
            $max_connections = $_POST['max_connections'];
            $bouquets = $_POST['bouquets'];
            $access_output = $_POST['access_output'];
            $contact = isset($_POST['contact']) ? $_POST['contact'] : "";
            $reseller_notes = isset($_POST['reseller_notes']) ? $_POST['reseller_notes'] : "";

            // Función para crear una línea
            function createLine($api_key, $username, $password, $max_connections, $bouquets_selected, $access_output, $contact, $reseller_notes) {
                $url = 'http://172.16.18.20/APIsomos/?api_key=' . $api_key . '&action=create_line&username=' . urlencode($username) . '&password=' . urlencode($password) . '&max_connections=' . $max_connections . '&bouquets_selected=' . urlencode(json_encode($bouquets_selected)) . '&access_output=' . urlencode(json_encode($access_output)) . '&contact=' . urlencode($contact) . '&reseller_notes=' . urlencode($reseller_notes);
                return makeRequest($url);
            }

            // Ejecuta la función para crear una línea
            $response = createLine($api_key, $username, $password, $max_connections, $bouquets, $access_output, $contact, $reseller_notes);

            // Verifica si la creación fue exitosa
            if ($response !== false) {
                // Decodifica la respuesta JSON
                $data = json_decode($response, true);

                // Verifica si la solicitud fue exitosa
                if ($data['status'] === 'STATUS_SUCCESS') {
                    echo "<p>Usuario creado exitosamente.</p>";
                } else {
                    // Si la solicitud no fue exitosa, muestra un mensaje de error
                    echo 'Error: La solicitud a la API no fue exitosa.';
                }
            } else {
                // Si hubo un error en la solicitud
                echo 'Error de cURL: No se pudo obtener una respuesta de la API.';
            }
        } else {
            // Si no se han enviado todos los campos necesarios, muestra un mensaje de error
            echo "Por favor, complete todos los campos.";
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
</body>
</html>
