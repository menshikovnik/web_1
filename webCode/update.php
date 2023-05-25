<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "users";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error connecting to database: " . $conn->connect_error);
}

// Получение данных из POST-запроса
$userId = $_POST["id"];
$userName = $_POST["name"];
$userEmail = $_POST["email"];

// Запрос на получение предыдущих данных о пользователе
$sql = "SELECT name, email FROM users WHERE id = '$userId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $prevName = $row["name"];
    $prevEmail = $row["email"];
} else {
    // Пользователь с заданным ID не найден
    echo "User not found";
    exit;
}

// Обновление данных пользователя с учетом предыдущих значений
$newName = $userName != "" ? $userName : $prevName;
$newEmail = $userEmail != "" ? $userEmail : $prevEmail;

// Запрос на обновление данных пользователя
$sql = "UPDATE users SET name = '$newName', email = '$newEmail' WHERE id = '$userId'";
if ($conn->query($sql) === TRUE) {
    // Обновление выполнено успешно
    echo "<script>window.location.href = 'users.php';</script>";
    exit;
} else {
    echo "Error updating user";
}

$conn->close();