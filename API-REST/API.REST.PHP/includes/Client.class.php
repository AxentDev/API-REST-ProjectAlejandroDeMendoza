<?php
require_once('Database.class.php');

class Client {

    // Crear un nuevo cliente
    public static function create_client($email, $name, $city, $telephone) {
        if (empty($email) || empty($name) || empty($city) || empty($telephone)) {
            http_response_code(400);
            echo json_encode(["message" => "Todos los campos son obligatorios"]);
            return;
        }

        try {
            $conn = (new Database())->getConnection();
            $stmt = $conn->prepare('INSERT INTO listado_clientes(email, name, city, telephone)
                VALUES(:email, :name, :city, :telephone)');
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':telephone', $telephone);

            if ($stmt->execute()) {
                http_response_code(201);
                echo json_encode(["message" => "Cliente creado correctamente"]);
            } else {
                http_response_code(500);
                echo json_encode(["message" => "Hubo un error al crear el cliente"]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["message" => "Error en la base de datos: " . $e->getMessage()]);
        }
    }

    // Eliminar cliente por ID
    public static function delete_client_by_id($id) {
        if (empty($id)) {
            http_response_code(400);
            echo json_encode(["message" => "ID es obligatorio"]);
            return;
        }

        try {
            $conn = (new Database())->getConnection();
            $stmt = $conn->prepare('DELETE FROM listado_clientes WHERE id=:id');
            $stmt->bindParam(':id', $id);
            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode(["message" => "Cliente borrado correctamente"]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Cliente no encontrado"]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["message" => "Error en la base de datos: " . $e->getMessage()]);
        }
    }

    // Obtener todos los clientes
    public static function get_all_clients() {
        try {
            $conn = (new Database())->getConnection();
            $stmt = $conn->prepare('SELECT * FROM listado_clientes');
            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            } else {
                http_response_code(404);
                echo json_encode(["message" => "No se han encontrado clientes"]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["message" => "Error en la base de datos: " . $e->getMessage()]);
        }
    }

    // Actualizar cliente por ID
    public static function update_client($id, $email, $name, $city, $telephone) {
        if (empty($id) || empty($email) || empty($name) || empty($city) || empty($telephone)) {
            http_response_code(400);
            echo json_encode(["error" => true, "message" => "Todos los campos son obligatorios"]);
            exit();  // 🔴 Detiene la ejecución después de la respuesta
        }

        try {
            $conn = (new Database())->getConnection();
            $stmt = $conn->prepare('UPDATE listado_clientes SET email=:email, name=:name, city=:city, telephone=:telephone WHERE id=:id');
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':telephone', $telephone);
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                http_response_code(200);
                echo json_encode(["success" => true, "message" => "Cliente actualizado correctamente"]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => true, "message" => "No se pudo actualizar el cliente. Verifique que el ID existe."]);
            }

            exit(); // 🔴 Asegura que solo se envía una respuesta y detiene la ejecución

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => true, "message" => "Error en la base de datos: " . $e->getMessage()]);
            exit(); // 🔴 Detiene la ejecución tras la respuesta
        }
    }



}
?>
