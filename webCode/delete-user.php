<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "users";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

// Получение ID пользователя из POST-запроса
if (isset($_POST['id'])) {
    $userId = $_POST['id'];

    // Подготовка и выполнение запроса на удаление пользователя
    $sql = "DELETE FROM Users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId); //bind_param обеспечит защиту от инъекций, так как значение будет правильно экранировано при выполнении запроса.

    if ($stmt->execute()) {
        // Успешное выполнение запроса
        echo "success";
    } else {
        // Ошибка при выполнении запроса
        echo "error";
    }

    $stmt->close();
}

$conn->close();