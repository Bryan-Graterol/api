<?php
// Función para obtener los datos del usuario por ID 
function getUserData($id) {
    // API key
    $api_key = "C46B07DD21675C0AAC4FEFE100F49168";

    // Construye la URL de la API con la API key y el ID
    $url = 'http://172.16.18.20/APIsomos/?api_key=' . $api_key . '&action=get_line&id=' . $id;

    // Inicializa cURL
    $curl = curl_init();

    // Configura opciones de cURL
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // Ejecuta la solicitud y captura la respuesta
    $response = curl_exec($curl);

    // Verifica si la solicitud fue exitosa
    if ($response === false) {
        // Si hubo un error en la solicitud
        echo 'Error de cURL: ' . curl_error($curl);
        return null;
    } else {
        // Si la solicitud fue exitosa, decodifica la respuesta JSON
        $data = json_decode($response, true);
        // Verifica si la solicitud fue exitosa
        if ($data['status'] === 'STATUS_SUCCESS') {
            // Extrae los datos necesarios
            return $data['data'];
        } else {
            // Si la solicitud no fue exitosa, muestra un mensaje de error
            echo 'Error: La solicitud a la API no fue exitosa.';
            return null;
        }
    }

    // Cierra cURL
    curl_close($curl);
}


?>