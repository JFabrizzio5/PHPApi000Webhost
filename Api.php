<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "id20625723_root";
$password = "%N0m3l0%";
$database = "id20625723_root";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar el método de solicitud HTTP
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Consulta SQL para obtener los datos
    $sql = "SELECT Id_Chat, Id_Usu, Id_Usu2, Mensaje FROM Chat";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        echo json_encode(["message" => "No se encontraron registros en la tabla."]);
    }
} elseif ($method === 'POST') {
    // Obtener datos del cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['mensaje_personalizado'])) {
        // Actualizar registros con "Id_Chat" nulo
        $mensaje_personalizado = $data['mensaje_personalizado'];

        $sql = "UPDATE Chat SET Mensaje = '$mensaje_personalizado' WHERE Id_Chat IS NULL";

        if ($conn->query($sql) === TRUE) {
            header('Content-Type: application/json');
            echo json_encode(["message" => "Registros actualizados exitosamente."]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(["error" => "Error al actualizar los registros: " . $conn->error]);
        }
    } else {
        // Crear un nuevo registro si no se proporciona "mensaje_personalizado"
        if (!empty($data['Id_Usu']) && !empty($data['Id_Usu2']) && !empty($data['Mensaje'])) {
            // Insertar el nuevo registro en la base de datos
            $id_usu = $data['Id_Usu'];
            $id_usu2 = $data['Id_Usu2'];
            $mensaje = $data['Mensaje'];

            $sql = "INSERT INTO Chat (Id_Usu, Id_Usu2, Mensaje) VALUES ('$id_usu', '$id_usu2', '$mensaje')";

            if ($conn->query($sql) === TRUE) {
                header('Content-Type: application/json');
                echo json_encode(["message" => "Nuevo registro creado exitosamente."]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(["error" => "Error al crear el registro: " . $conn->error]);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(["error" => "Datos incompletos para realizar la actualización o crear un nuevo registro."]);
        }
    }
}

$conn->close();
?>