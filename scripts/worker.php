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
    <title>Сотрудники</title>
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
        select {
            width: calc(100% - 10px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
            background-color: #45a049;
        }

        a {
            text-align: center;
            color: #333;
            text-decoration: none;
            margin-top: 20px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Сотрудники</h1>

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
    $sql = "SELECT wid, wname, speciality, shift FROM workers";
    $result = $conn->query($sql);

    // Проверяем, есть ли данные
    if ($result->num_rows > 0) {
        // Создаем таблицу
        echo "<table><tr><th>ID</th><th>Имя</th><th>Специальность</th><th>Смена</th><th>Действие</th></tr>";
        // Выводим данные каждой строки
        while ($row = $result->fetch_assoc()) {
            // Заполняем таблицу данными
            echo "<tr><form action='worker.php' method='get'><td>" . $row["wid"] . "</td><td><input type='text' name='wname' value='" . $row["wname"] . "' required></td><td><select name='speciality' required><option value='охранник' " . ($row["speciality"] == "охранник" ? "selected" : "") . ">Охранник</option><option value='бухгалтер' " . ($row["speciality"] == "бухгалтер" ? "selected" : "") . ">Бухгалтер</option><option value='грузчик' " . ($row["speciality"] == "грузчик" ? "selected" : "") . ">Грузчик</option><option value='ИС' " . ($row["speciality"] == "ИС" ? "selected" : "") . ">ИС</option></select></td><td><select name='shift' required><option value='день' " . ($row["shift"] == "день" ? "selected" : "") . ">День</option><option value='ночь' " . ($row["shift"] == "ночь" ? "selected" : "") . ">Ночь</option></select></td><td><input type='hidden' name='wid' value='" . $row["wid"] . "'><input type='submit' name='action' value='Удалить'><input type='submit' name='action' value='Обновить'></td></form></tr>";
        }
        // Закрываем таблицу
        echo "</table>";
    } else {
        echo "0 результатов";
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["action"])) {
        $wid = $_GET["wid"];
        $wname = $_GET["wname"];
        $speciality = $_GET["speciality"];
        $shift = $_GET["shift"];
        $action = $_GET["action"];

        if ($action == "Удалить") {
            $sql = "DELETE FROM workers WHERE wid='$wid'";
            if (mysqli_query($conn, $sql)) {
                echo "Запись успешно удалена";
            } else {
                echo "Ошибка: " . mysqli_error($conn);
            }
        } elseif ($action == "Обновить") {
            $sql = "SELECT * FROM workers WHERE (wname ='$wname') AND wid !='$wid'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo "Ошибка: запись с таким же именем, специальностью или сменой уже существует";
            } else {
                $sql = "UPDATE workers SET wname='$wname', speciality='$speciality', shift='$shift' WHERE wid='$wid'";
                if (mysqli_query($conn, $sql)) {
                    echo "Запись успешно обновлена";
                } else {
                    echo "Ошибка: " . mysqli_error($conn);
                }
            }
        } elseif ($action == "Добавить") {
            $sql = "SELECT * FROM workers WHERE wname='$wname'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo "Ошибка: запись с таким же именем уже существует";
            } else {
                $sql = "INSERT INTO workers (wname, speciality, shift) VALUES ('$wname', '$speciality', '$shift')";
                if (mysqli_query($conn, $sql)) {
                    echo "Запись успешно добавлена";
                } else {
                    echo "Ошибка: " . mysqli_error($conn);
                }
            }
        }

        echo "<script>
        setTimeout(() => {
            window.location.href = 'http://localhost/course/scripts/worker.php';
        }, 800);
        </script>";
    }

    $conn->close();
    ?>

    <form action="worker.php" method="get">
        <h2>Добавить сотрудника</h2>
        <label for="wname">Имя:</label>
        <input type="text" name="wname" id="wname" required>

        <label for="speciality">Специальность:</label>
        <select name="speciality" id="speciality" required>
            <option value="охранник">Охранник</option>
            <option value="бухгалтер">Бухгалтер</option>
            <option value="грузчик">Грузчик</option>
            <option value="ИС">ИС</option>
        </select>

        <label for="shift">Смена:</label>
        <select name="shift" id="shift" required>
            <option value="день">День</option>
            <option value="ночь">Ночь</option>
        </select>

        <input type="submit" name="action" value="Добавить">
        <br>
        <button type="button" onclick="document.location='http://localhost/course/users/HR.php'">Назад</button>
    </form>
</body>

</html>
