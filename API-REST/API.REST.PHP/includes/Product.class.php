<?php
require_once('Database.class.php');

class Product {

    // Crear un nuevo producto
    public static function create_product($name, $description, $price) {
        if (empty($name) || empty($description) || empty($price)) {
            http_response_code(400);
            echo json_encode(["message" => "Todos los campos son obligatorios"]);
            return;
        }

        try {
            $conn = (new Database())->getConnection();
            $stmt = $conn->prepare('INSERT INTO productos(name, description, price) VALUES(:name, :description, :price)');
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);

            if ($stmt->execute()) {
                http_response_code(201);
                echo json_encode(["message" => "Producto creado correctamente"]);
            } else {
                http_response_code(500);
                echo json_encode(["message" => "Hubo un error al crear el producto"]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["message" => "Error en la base de datos: " . $e->getMessage()]);
        }
    }

    // Eliminar producto por ID
    public static function delete_product_by_id($id) {
        if (empty($id)) {
            http_response_code(400);
            echo json_encode(["message" => "ID es obligatorio"]);
            return;
        }

        try {
            $conn = (new Database())->getConnection();
            $stmt = $conn->prepare('DELETE FROM productos WHERE id=:id');
            $stmt->bindParam(':id', $id);
            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode(["message" => "Producto borrado correctamente"]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Producto no encontrado"]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["message" => "Error en la base de datos: " . $e->getMessage()]);
        }
    }

    // Obtener todos los productos
    public static function get_all_products() {
        try {
            $conn = (new Database())->getConnection();
            $stmt = $conn->prepare('SELECT * FROM productos');
            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            } else {
                http_response_code(404);
                echo json_encode(["message" => "No se han encontrado productos"]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["message" => "Error en la base de datos: " . $e->getMessage()]);
        }
    }

    // Actualizar producto por ID
    public static function update_product($id, $name, $description, $price) {
        if (empty($id) || empty($name) || empty($description) || empty($price)) {
            http_response_code(400);
            echo json_encode(["message" => "Todos los campos son obligatorios"]);
            return;
        }

        try {
            $conn = (new Database())->getConnection();
            $stmt = $conn->prepare('UPDATE productos SET name=:name, description=:description, price=:price WHERE id=:id');
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                http_response_code(200);
                echo json_encode(["message" => "Producto actualizado correctamente"]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "No se pudo actualizar el producto. Verifique que el ID existe."]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["message" => "Error en la base de datos: " . $e->getMessage()]);
        }
    }
}
?>
