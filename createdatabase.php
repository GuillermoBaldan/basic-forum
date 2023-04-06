<?php

// Configuración y conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Crear base de datos si no existe
$sql = "CREATE DATABASE IF NOT EXISTS papeleria CHARACTER SET utf8;";
if ($conn->query($sql) === TRUE) {
    echo "Base de datos 'papeleria' creada correctamente<br>";
} else {
    echo "Error al crear la base de datos: " . $conn->error;
}

// Seleccionar base de datos
$conn->select_db($dbname);

// Crear tabla Categoria si no existe
$sql = "CREATE TABLE IF NOT EXISTS Categoria (
  id_categoria INT AUTO_INCREMENT PRIMARY KEY,
  nombre_categoria VARCHAR(50)
);";
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'Categoria' creada correctamente<br>";
} else {
    echo "Error al crear la tabla 'Categoria': " . $conn->error;
}

// Crear tabla Articulo si no existe
$sql = "CREATE TABLE IF NOT EXISTS Articulo (
id_articulo INT AUTO_INCREMENT PRIMARY KEY,
nombre_articulo VARCHAR(50),
descripcion_articulo VARCHAR(255),
precio_articulo DECIMAL(10,2),
stock_articulo INT,
id_categoria INT,
foto_articulo_url VARCHAR(255),
FOREIGN KEY (id_categoria) REFERENCES Categoria(id_categoria)
);";
if ($conn->query($sql) === TRUE) {
echo "Tabla 'Articulo' creada correctamente<br>";
} else {
echo "Error al crear la tabla 'Articulo': " . $conn->error;
}

// Crear tabla Usuario si no existe
$sql = "CREATE TABLE IF NOT EXISTS Usuario (
id_usuario INT(11) AUTO_INCREMENT PRIMARY KEY,
nombre_usuario VARCHAR(50),
correo_usuario VARCHAR(50),
contraseña_usuario VARCHAR(255)
);";
if ($conn->query($sql) === TRUE) {
echo "Tabla 'Usuario' creada correctamente<br>";
} else {
echo "Error al crear la tabla 'Usuario': " . $conn->error;
}

// Generar el hash de la contraseña "superuser"
$password = "superuser";
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insertar el usuario 'superuser' en la tabla 'Usuario' si no existe
$sql = "INSERT INTO Usuario (id_usuario, nombre_usuario, correo_usuario, contraseña_usuario)
SELECT 1, 'superuser', 'superuser@example.com', '$password_hash'
WHERE NOT EXISTS (SELECT * FROM Usuario WHERE id_usuario = 1);";
if ($conn->query($sql) === TRUE) {
echo "Usuario 'superuser' insertado correctamente<br>";
} else {
echo "Error al insertar el usuario 'superuser': " . $conn->error;
}

// Cerrar conexión
$conn->close();

?>
