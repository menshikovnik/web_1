<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "users";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

// Получение данных из POST-запроса
$userId = $_POST["id"];
$userName = $_POST["name"];
$userEmail = $_POST["email"];

// Подготовка и выполнение запроса на добавление пользователя
$sql = "INSERT INTO users (id, name, email) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $userId, $userName, $userEmail);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();