<?php
    require_once('../includes/Client.class.php');

    // Verificar que el método de solicitud sea POST y que todos los parámetros estén presentes
    if ($_SERVER['REQUEST_METHOD'] == 'POST' 
        && isset($_POST['email']) && isset($_POST['name']) && isset($_POST['city']) && isset($_POST['telephone'])) {

        // Recuperar los parámetros del formulario
        $email = $_POST['email'];
        $name = $_POST['name'];
        $city = $_POST['city'];
        $telephone = $_POST['telephone'];

        // Llamar a la función para crear el cliente
        Client::create_client($email, $name, $city, $telephone);

    } else {
        // Si los parámetros no están presentes o el método no es POST, devolver un error
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(["message" => "Faltan parámetros obligatorios o método incorrecto."]);
    }
?>
