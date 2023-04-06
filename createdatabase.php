<?php

// Incluir la configuración de la base de datos
include 'db_config.php';

// Crear base de datos si no existe
$sql = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8;";
if ($conn->query($sql) === TRUE) {
    echo "Base de datos 'forum' creada correctamente<br>";
} else {
    echo "Error al crear la base de datos: " . $conn->error;
}

// Seleccionar base de datos
$conn->select_db($dbname);

// Crear tabla Usuarios si no existe
$sql = "CREATE TABLE IF NOT EXISTS Usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL
);";
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'Usuarios' creada correctamente<br>";
} else {
    echo "Error al crear la tabla 'Usuarios': " . $conn->error;
}

// Crear tabla Categorias si no existe
$sql = "CREATE TABLE IF NOT EXISTS Categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(255) NOT NULL
);";
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'Categorias' creada correctamente<br>";
} else {
    echo "Error al crear la tabla 'Categorias': " . $conn->error;
}

// Crear tabla Preguntas si no existe
$sql = "CREATE TABLE IF NOT EXISTS Preguntas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    texto TEXT NOT NULL,
    fecha DATE NOT NULL,
    usuario_id INT NOT NULL,
    categoria_id INT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id),
    FOREIGN KEY (categoria_id) REFERENCES Categorias(id)
);";
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'Preguntas' creada correctamente<br>";
} else {
    echo "Error al crear la tabla 'Preguntas': " . $conn->error;
}

// Crear tabla Respuestas si no existe
$sql = "CREATE TABLE IF NOT EXISTS Respuestas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    texto TEXT NOT NULL,
    fecha DATE NOT NULL,
    pregunta_id INT NOT NULL,
    usuario_id INT NOT NULL,
    FOREIGN KEY (pregunta_id) REFERENCES Preguntas(id),
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id)
);";
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'Respuestas' creada correctamente<br>";
} else {
    echo "Error al crear la tabla 'Respuestas': " . $conn->error;
}

// Generar el hash de la contraseña "superuser"
$password = "superuser";
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insertar el usuario 'superuser' en la tabla 'Usuarios' si no existe
$sql = "INSERT INTO Usuarios (nombre, contraseña, email)
SELECT 'superuser', '$password_hash', 'superuser@example.com'
FROM DUAL
WHERE NOT EXISTS (SELECT * FROM Usuarios WHERE email = 'superuser@example.com');";
if ($conn->query($sql) === TRUE) {
    echo "Usuario 'superuser' insertado correctamente<br>";
} else {
    echo "Error al insertar el usuario 'superuser': " . $conn->error;
}

// Cerrar conexión
$conn->close();

?>
