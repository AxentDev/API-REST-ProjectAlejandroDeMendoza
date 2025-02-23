<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API REST - Gestión de Clientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 20px auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        button {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <header>
        <h1>Gestión de Clientes</h1>
    </header>

    <div class="container">
        <!-- Formulario de creación -->
        <div class="form-container" id="create-client-form">
            <h3>Crear Nuevo Cliente</h3>
            <input type="text" id="name" placeholder="Nombre del Cliente" required>
            <input type="email" id="email" placeholder="Correo Electrónico" required>
            <input type="text" id="phone" placeholder="Teléfono" required>
            <button onclick="createClient()">Crear Cliente</button>
        </div>

        <!-- Lista de clientes -->
        <h3>Lista de Clientes</h3>
        <table id="clients-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <script>
        // Función para crear un cliente
        function createClient() {
            let name = document.getElementById('name').value;
            let email = document.getElementById('email').value;
            let phone = document.getElementById('phone').value;

            fetch('http://localhost/api_rest_php/api-rest/create_client.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    phone: phone
                })
            })
            .then(response => response.json())
            .then(data => {
                alert('Cliente creado exitosamente');
                getAllClients(); // Actualiza la lista de clientes
            })
            .catch(error => console.error('Error:', error));
        }

        // Función para obtener todos los clientes
        function getAllClients() {
            fetch('http://localhost/api_rest_php/api-rest/get_all_client.php')
            .then(response => response.json())
            .then(data => {
                let tableBody = document.getElementById('clients-table').getElementsByTagName('tbody')[0];
                tableBody.innerHTML = ''; // Limpiar tabla
                data.forEach(client => {
                    let row = tableBody.insertRow();
                    row.innerHTML = `
                        <td>${client.id}</td>
                        <td>${client.name}</td>
                        <td>${client.email}</td>
                        <td>${client.phone}</td>
                        <td>
                            <button onclick="editClient(${client.id})">Editar</button>
                            <button onclick="deleteClient(${client.id})">Eliminar</button>
                        </td>
                    `;
                });
            })
            .catch(error => console.error('Error:', error));
        }

        // Función para editar un cliente
        function editClient(id) {
            let newName = prompt("Nuevo nombre:");
            let newEmail = prompt("Nuevo correo:");
            let newPhone = prompt("Nuevo teléfono:");

            fetch('http://localhost/api_rest_php/api-rest/update_client.php', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: id,
                    name: newName,
                    email: newEmail,
                    phone: newPhone
                })
            })
            .then(response => response.json())
            .then(data => {
                alert('Cliente actualizado');
                getAllClients(); // Actualiza la lista de clientes
            })
            .catch(error => console.error('Error:', error));
        }

        // Función para eliminar un cliente
        function deleteClient(id) {
            fetch(`http://localhost/api_rest_php/api-rest/delete_client.php?id=${id}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                alert('Cliente eliminado');
                getAllClients(); // Actualiza la lista de clientes
            })
            .catch(error => console.error('Error:', error));
        }

        // Cargar los clientes al cargar la página
        window.onload = getAllClients;
    </script>
</body>
</html>
