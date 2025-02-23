<?php
    class Database {
        private $host = 'localhost:3306'; // Asegúrate de que este es el puerto correcto de MySQL en tu XAMPP.
        private $user = 'root';           // Asegúrate de que estas credenciales sean correctas.
        private $password = '';       // Asegúrate de que estas credenciales sean correctas.
        private $database = 'code_pills'; // El nombre de la base de datos.

        public function getConnection() {
            // Se establece el charset=utf8 para evitar problemas con caracteres especiales.
            $hostDB = "mysql:host=".$this->host.";dbname=".$this->database.";charset=utf8";

            try {
                // Establecemos la conexión con los parámetros proporcionados.
                $connection = new PDO($hostDB, $this->user, $this->password);
                // Establecemos el modo de error para obtener excepciones en caso de error.
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // Configuramos el modo de búsqueda para que los resultados sean un array asociativo por defecto.
                $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                return $connection;
            } catch (PDOException $e) {
                // En caso de error, mostramos un mensaje de error detallado.
                die("ERROR: No se pudo establecer la conexión con la base de datos. Detalles: " . $e->getMessage());
            }
        }
    }
?>
