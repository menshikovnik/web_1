<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users</title>
    <style>
        body {
            background-color: #fff;
            color: #2b1a0e;
            font-family: Arial, sans-serif;
            font-size: 18px;
            margin: 0;
        }

        header {
            background-color: #1e90ff;
            color: #fff;
            padding: 15px;
        }

        header h1 {
            font-size: 2em;
            margin: 0;
        }

        main {
            max-width: 800px;
            margin: auto;
            padding: 25px;
        }

        main h2 {
            font-size: 1.8em;
            text-align: center;
            margin-top: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #1e90ff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        footer {
            background-color: #1e90ff;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .delete-button {
            background-color: #ff0000;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #cc0000;
        }
        .update-button {
            background-color: #1e90ff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .update-button:hover {
            background-color: #005eff;
        }
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .form-group input[type="submit"] {
            background-color: #1e90ff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-group input[type="submit"]:hover {
            background-color: #187bcd;
        }
        .search-results {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .search-results p {
            margin: 0;
        }
        .search-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-container h2 {
            text-align: center;
        }

        .search-form {
            margin-top: 20px;
        }
        body {
            background-color: #fff;
            color: #2b1a0e;
            font-family: Arial, sans-serif;
            font-size: 18px;
            margin: 0;
        }

    </style>
</head>
<body>
<header>
    <center><h1>Users</h1></center>
    <h1><a href="AboutMe.html">To main</a></h1>
</header>
<main>
    <h2>List of users</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "users";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Error connecting to database: " . $conn->connect_error);
        }

        // Выборка данных из базы данных
        $sql = "SELECT id, name, email FROM users";
        $stmt = $conn->prepare($sql);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Вывод данных в таблицу
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td><button class='delete-button' onclick='deleteUser(" . $row["id"] . ")'>Delete</button></td>";
                    echo "<td><button class='update-button' onclick='updateUser(" . $row["id"] . ")'>Update</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No users available</td></tr>";
            }
        } else {
            echo "Error executing query: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
        ?>

    </table>
    <h2>Add user manually</h2>
    <div class="form-group">
        <form id="addUserForm">
            <label for="userId">ID:</label>
            <input type="text" id="userId" name="userId"><br>
            <label for="userName">Name:</label>
            <input type="text" id="userName" name="userName"><br>
            <label for="userEmail">Email:</label>
            <input type="email" id="userEmail" name="userEmail"><br>
            <input type="submit" value="Add">
        </form>
    </div>
    <title>Search for ID</title>
    <body>
    <div class="search-container">
        <h2>Search for ID</h2>
        <form class="search-form" action="" method="post">
            <div class="form-group">
                <label for="id">ID:</label>
                <input type="text" id="id" name="id" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Search">
            </div>
        </form>
    </div>

    <?php
    // Проверка, была ли отправлена форма поиска
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Подключение к базе данных
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "users";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Проверка соединения
        if ($conn->connect_error) {
            die("Connection error: " . $conn->connect_error);
        }

        // Обработка запроса поиска
        $id = $_POST['id'];

        // Защита от SQL-инъекций
        $id = mysqli_real_escape_string($conn, $id);

        // Подготовленный SQL-запрос
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Вывод результатов поиска
            echo '<div class="search-results">';
            while ($row = $result->fetch_assoc()) {
                echo '<p>ID: ' . $row["id"] . '</p>';
                echo '<p>Name: ' . $row["name"] . '</p>';
                echo '<p>Email: ' . $row["email"] . '</p>';
            }
            echo '</div>';
        } else {
            echo '<div class="search-results">Record not found</div>';
        }

        $stmt->close();
        $conn->close();
    }
    ?>
    </body>
    </body>
</main>
<footer>
    <h1>Thanks for visiting!</h1>
</footer>
<script>
    document.getElementById("addUserForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Предотвращаем отправку формы по умолчанию

        // Получаем значения полей формы
        const userId = document.getElementById("userId").value;
        const userName = document.getElementById("userName").value;
        const userEmail = document.getElementById("userEmail").value;

        // Отправляем данные на сервер для добавления пользователя
        fetch("add-user.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id=" + userId + "&name=" + encodeURIComponent(userName) + "&email=" + encodeURIComponent(userEmail)
        })
            .then(response => {
                if (response.ok) {
                    // Перезагрузка страницы после успешного добавления
                    location.reload();
                } else {
                    throw new Error("Error adding user.");
                }
            })
            .catch(error => {
                alert(error.message);
            });
    });
</script>
<script>
    const deleteUser = userId => {
        if (confirm("Are you sure you want to remove the user from the ID " + userId + "?")) {
            // Отправка запроса на удаление пользователя
            const xhr = new XMLHttpRequest();
            xhr.open("POST", `delete-user.php`, true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Обработка ответа
                    if (xhr.responseText === "success") {
                        // Перезагрузка страницы после успешного удаления
                        location.reload();
                    } else {
                        alert("Ошибка удаления пользователя.");
                    }
                }
            };
            xhr.send("id=" + userId);
        }
    };
    function updateUser(userId) {
        // Получаем данные о пользователе, которые нужно обновить (например, из формы)
        const newName = prompt("Enter new name:");
        const newEmail = prompt("Enter new email:");

        // Создаем объект FormData и добавляем данные для отправки на сервер
        const formData = new FormData();
        formData.append("id", userId);
        formData.append("name", newName);
        formData.append("email", newEmail);

        // Создаем и отправляем AJAX-запрос на сервер
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update.php", true);
        xhr.onload = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Обработка ответа сервера после успешного обновления данных
                const response = xhr.responseText;
                if (response === "success") {
                    location.reload();
                    alert("User data updated successfully.");
                } else {
                    alert("Error updating user data.");
                }
            }
        };
        xhr.send(formData);
    }

</script>
</html>