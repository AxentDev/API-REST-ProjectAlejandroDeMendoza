<?php
    require_once('../includes/Client.class.php');

    // Verificar que el método de solicitud sea GET
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        
        // Llamar a la función para obtener todos los clientes
        Client::get_all_clients();

    } else {
        // Si el método no es GET, devolver un error
        header('HTTP/1.1 405 Method Not Allowed');
        echo json_encode(["message" => "Método no permitido. Solo se permite GET."]);
    }
?>
