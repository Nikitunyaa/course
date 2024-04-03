<?php
session_start();

if ($_SESSION["position"] != "HR") {
    header("Location: http://localhost/course/index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Клиенты</title>
    <style>
        body {
            background-color: #3498db;
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        h1 {
            color: #fff;
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 90%;
            margin: 20px auto;
            background-color: #0077cc;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        table th,
        table td {
            padding: 10px;
            border: 2px solid #004080;
            border-radius: 5px;
        }

        table th {
            background-color: #004080;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #002b4d;
        }

        table tr:hover {
            background-color: #004080;
        }

        form {
            width: 90%;
            margin: 0 auto;
            background-color: #0077cc;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            margin-top: 20px;
            text-align: center;
        }

        label {
            margin-right: 5px;
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            text-align: center;
        }

        input[type="text"],
        input[type="password"] {
            padding: 5px;
            border: 2px solid #004080;
            border-radius: 5px;
            margin-bottom: 5px;
            margin-right: 5px;
            width: 70%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #004080;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #002b4d;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #fff;
            text-decoration: none;
            margin-bottom: 20px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Клиенты</h1>

    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "course";

    $conn = new mysqli($servername, $username, $password, $dbname);

    mysqli_set_charset($conn, "utf8");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Просмотр таблицы
    $sql = "SELECT cid, cname, city FROM customers";
    $result = $conn->query($sql);

    // Проверяем, есть ли данные
    if ($result->num_rows > 0) {
        // Создаем таблицу
        echo "<table border=1><tr><th>ID</th><th>Имя</th><th>Город</th><th>Действие</th></tr>";
        // Выводим данные каждой строки
        while ($row = $result->fetch_assoc()) {
            // Заполняем таблицу данными
            echo "<tr><form action='hrm.php' method='get'><td>" . $row["cid"] . "</td><td><input type='text' name='cname' value='" . $row["cname"] . "' required></td><td><input type='text' name='city' value='" . $row["city"] . "' required></td><td><input type='hidden' name='cid' value='" . $row["cid"] . "'><input type='submit' name='action' value='Удалить'><input type='submit' name='action' value='Обновить'></td></form></tr>";
        }
        // Закрываем таблицу
        echo "</table>";
    } else {
        echo "0 результатов";
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["action"])) {
    $cid = $_GET["cid"];
    $cname = $_GET["cname"];
    $city = $_GET["city"];
    $action = $_GET["action"];

    if ($action == "Удалить") {
        $sql = "DELETE FROM customers WHERE cid='$cid'";
        if (mysqli_query($conn, $sql)) {
            echo "Запись успешно удалена";
        } else {
            echo "Ошибка: " . mysqli_error($conn);
        }
    } elseif ($action == "Обновить") {
        $sql = "SELECT * FROM customers WHERE (cname ='$cname') AND cid !='$cid'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo "Ошибка: запись с таким же именем или городом уже существует";
        } else {
            $sql = "UPDATE customers SET cname='$cname', city='$city' WHERE cid='$cid'";
            if (mysqli_query($conn, $sql)) {
                echo "Запись успешно обновлена";
            } else {
                echo "Ошибка: " . mysqli_error($conn);
            }
        }
    } elseif($action == "Добавить") {
        $sql = "SELECT * FROM customers WHERE cname='$cname'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo "Ошибка: запись с таким же именем уже существует";
        } else {
            $sql = "INSERT INTO customers (cname, city) VALUES ('$cname', '$city')";
            if (mysqli_query($conn, $sql)) {
                echo "Запись успешно добавлена";
            } else {
                echo "Ошибка: " . mysqli_error($conn);
            }
        }
    }

echo "<script>
    setTimeout(() => {
        window.location.href = 'http://localhost/course/scripts/hrm.php';
    }, 800);
</script>
";

}

    $conn->close();
    ?>

    <form action="hrm.php" method="get">
        <label for="cname">Имя:</label>
        <input type="text" name="cname" id="cname" required><br>

        <label for="city">Город:</label>
        <input type="text" name="city" id="city" required><br>

        <input type="submit" name="action" value="Добавить">
        <br>
        <button type="submit" onclick="document.location='http://localhost/course/users/HR.php'">Назад</button>
    </form>
</body>

</html>
