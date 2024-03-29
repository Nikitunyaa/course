<?php
// Подключение к базе данных
session_start();

if ($_SESSION["position"] != "admin") {
    header("Location: http://localhost/course/index.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "course";

$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Запрос на выборку данных из таблицы "users"
$sql = "SELECT id, login, password, position FROM users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #3498db;
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        h1 {
            color: white;
            text-align: center;
            margin-top: 20px;
        }

        table {
            margin-top: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 300px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"],
        button {
            background-color: #2ecc71;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #27ae60;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #333;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Пользователи</h1>

    <?php
    // Проверяем, есть ли данные
    if ($result->num_rows > 0) {
        // Выводим данные в виде HTML таблицы
        echo "<table border=1>";
        echo "<tr><th>ID</th><th>Логин</th><th>Пароль</th><th>Должность</th><th>Действие</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr><form action='adminm.php' method='get'><td>" . $row["id"] . "</td><td><input type='text' name='login' value='" . $row["login"] . "' required></td><td><input type='text' name='password' value='" . $row["password"] . "' required></td><td><select name='position' required><option value='accountant' " . ($row["position"] == "accountant" ? "selected" : "") . ">Бухгалтер</option><option value='HR' " . ($row["position"] == "HR" ? "selected" : "") . ">HR</option><option value='admin' " . ($row["position"] == "admin" ? "selected" : "") . ">Администратор</option></select></td><td><input type='hidden' name='id' value='" . $row["id"] . "'><input type='submit' name='action' value='Удалить'><input type='submit' name='action' value='Обновить'></td></form></tr>";
        }

        echo "</table>";
    } else {
        echo "0 результатов";
    }

    // Обработка действия "Удалить" "Обновить"
    if ($_SERVER["REQUEST_METHOD"] == "GET" && ($_GET["action"] == "Удалить" || $_GET["action"] == "Обновить" || $_GET["action"] == "Добавить")) {
        $id = $_GET["id"];
        $login = $_GET["login"];
        $password = $_GET["password"];
        $position = $_GET["position"];

        if ($_GET["action"] == "Удалить") {
            $sql = "DELETE FROM users WHERE id='$id'";
            if (mysqli_query($conn, $sql)) {
                echo "Запись успешно удалена";
            } else {
                echo "Ошибка: " . mysqli_error($conn);
            }
        } elseif ($_GET["action"] == "Обновить") {
            $id = $_GET["id"];
            $login = $_GET["login"];
            $password = $_GET["password"];
            $position = $_GET["position"];

            $sql = "SELECT * FROM users WHERE (login='$login' OR password='$password') AND id!='$id'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo "Ошибка: запись с таким же логином или паролем уже существует";
            } else {
                $sql = "UPDATE users SET login='$login', password='$password', position='$position' WHERE id='$id'";
                if (mysqli_query($conn, $sql)) {
                    echo "Запись успешно обновлена";
                } else {
                    echo "Ошибка: " . mysqli_error($conn);
                }
            }
        } elseif ($_GET["action"] == "Добавить") {
            $login = $_GET["loginm"];
            $password = $_GET["passwordm"];
            $position = $_GET["positionm"];
            $sql = "SELECT * FROM users WHERE login='$login' OR password='$password'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                echo "Ошибка: запись с таким же логином или паролем уже существует";
            } else {
                $sql = "INSERT INTO users (login, password, position) VALUES ('$login', '$password', '$position')";
                if (mysqli_query($conn, $sql)) {
                    echo "Запись успешно добавлена";
                } else {
                    echo "Ошибка: " . mysqli_error($conn);
                }
            }
        }
        echo "<script>
        setTimeout(() => {
            window.location.href = 'http://localhost/course/scripts/adminm.php';
        }, 800);
    </script>";
    }

    $conn->close();

    ?>

    <form action="adminm.php" method="get">
        <label for="loginm">Логин:</label>
        <input type="text" name="loginm" id="loginm" required>
        <label for="passwordm">Пароль:</label>
        <input type="text" name="passwordm" id="passwordm" required>
        <label for="positionm">Должность:</label>
        <select id="positionm" name="positionm" required>
            <option value="accountant">Бухгалтер</option>
            <option value="HR">HR</option>
            <option value="admin">Администратор</option>
        </select>
        <input type="submit" name="action" value="Добавить">
        <button type="submit" name="back" id="back" onclick="document.location='http://localhost/course/users/admin.php'">Назад</button>
    </form>
</body>

</html>
