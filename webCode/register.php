<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "users";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных из формы регистрации
$id = $_POST["id"];
$name = $_POST["name"];
$email = $_POST["email"];

// Защита от SQL-инъекций
$name = mysqli_real_escape_string($conn, $name);
$email = mysqli_real_escape_string($conn, $email);
$id = mysqli_real_escape_string($conn, $id);

// Вставка нового пользователя в таблицу "users"
$sql = "INSERT INTO users (id, name, email) VALUES ('$id', '$name', '$email')";
if ($conn->query($sql) === TRUE) {
    echo "User registered successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Закрытие соединения с базой данных
$conn->close();