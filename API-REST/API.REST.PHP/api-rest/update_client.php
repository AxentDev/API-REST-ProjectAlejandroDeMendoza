<?php
require_once('../includes/Client.class.php');

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT); // Capturar datos PUT

    if (isset($_PUT['email']) && isset($_PUT['name']) && isset($_PUT['city']) && isset($_PUT['telephone'])) {
        $id = $_GET['id'] ?? null;
        $email = $_PUT['email'];
        $name = $_PUT['name'];
        $city = $_PUT['city'];
        $telephone = $_PUT['telephone'];

        if ($id) {
            Client::update_client($id, $email, $name, $city, $telephone);
            echo json_encode(["message" => "Cliente actualizado correctamente"]);
        } else {
            echo json_encode(["error" => true, "message" => "ID del cliente no proporcionado."]);
        }
    } else {
        echo json_encode(["error" => true, "message" => "Faltan parámetros requeridos."]);
    }
} else {
    echo json_encode(["error" => true, "message" => "Método no permitido."]);
}
