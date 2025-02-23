<?php
    require_once('../includes/Client.class.php');

    // Verificar que el método de solicitud sea DELETE y que el parámetro ID esté presente
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && isset($_GET['id'])) {
        
        // Recuperar el ID del parámetro de la URL
        $id = $_GET['id'];

        // Llamar a la función para eliminar el cliente por su ID
        Client::delete_client_by_id($id);

    } else {
        // Si el parámetro ID no está presente o el método no es DELETE, devolver un error
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(["message" => "Falta el parámetro 'id' o el método es incorrecto."]);
    }
?>
