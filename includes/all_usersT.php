<?php
// Función para conectarse a la base de datos
function connectToDatabase() {
    $host = "172.16.18.20";
    $user = "front";
    $password = "S0m0s2023*-";
    $database = "xui";
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        // Configura el modo de error de PDO para que lance excepciones
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

// Función para obtener todos los usuarios de la base de datos
function fetchUsersFromDatabase($pdo) {
    try {
        $statement = $pdo->query('SELECT * FROM xui.lines');
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error al recuperar usuarios: " . $e->getMessage());
    }
}

// Conexión a la base de datos
$pdo = connectToDatabase();

// Obtener todos los usuarios de la base de datos
$users = fetchUsersFromDatabase($pdo);

// Imprimir el título de la tabla y el estilo CSS
echo '<title>Consulta de Datos de Usuarios</title>';
echo '<style>table {border-collapse: collapse;width: 80%;margin: 20px auto;}th,td {border: 1px solid #ddd;padding: 8px;text-align: left;}th {background-color: #f2f2f2;}.pagination {display: flex; justify-content: center;}.pagination a {color: black; float: left; padding: 8px 16px; text-decoration: none; transition: background-color .3s;border: 1px solid #ddd;}.pagination a.active {background-color: #007bff; color: white; border: 1px solid #007bff;}.pagination a:hover:not(.active) {background-color: #ddd;}</style>';
echo '<table><tr><th>ID</th><th>Username</th></tr>';

// Iterar sobre los registros de la base de datos
foreach ($users as $user) {
    // Imprimir fila de la tabla con los datos del usuario
    echo '<tr><td>' . htmlspecialchars($user['id'] ?? '') . '</td><td>' . htmlspecialchars($user['username'] ?? '') . '</td></tr>';
}

// Cierra la tabla
echo '</table>';
?>
