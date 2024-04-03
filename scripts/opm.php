<?php
// Подключение к базе данных
session_start();

if ($_SESSION["position"] != "accountant") {
    header("Location: http://localhost/course/index.php");
    exit;
}

echo "<h1>Операции с товарами</h1>";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "course";

$conn = new mysqli($servername, $username, $password, $dbname);

mysqli_set_charset($conn, "utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//просмотр таблицы
$sql = "SELECT oid, amt, cid, pid, odate FROM operations";
$result = $conn->query($sql);

// Проверяем, есть ли данные
if ($result->num_rows > 0) {
    // Создаем таблицу
    echo "<table border=1><tr><th>ID операции</th><th>ID клиента</th><th>ID товара</th><th>Дата ухода</th><th>Количество</th></tr>";
    // Выводим данные каждой строки
    while ($row = $result->fetch_assoc()) {
        // Заполняем таблицу данными
        echo "<tr><td>" . $row["oid"] . "</td><td>" . $row["cid"] . "</td><td>" . $row["pid"] . "</td><td>" . $row["odate"] . "</td><td>" . $row["amt"] . "</td></tr>";
    }
    // Закрываем таблицу
    echo "</table>";
} else {
    echo "0 результатов";
}

$conn->close();
?>

<head>
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

        form {
            width: 90%;
            margin: 0 auto;
            background-color: #3498db;
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
        input[type="date"] {
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

<h1>Добавить операцию</h1>
<form action="op.php" method="post">

    <label for="amt">Количество товара:</label>
    <input type="text" name="amt" placeholder="Количество" required>
    <br>
    <label for="cid">ID клиента:</label>
    <input type="text" name="cid" placeholder="Код клиента" required>
    <br>
    <label for="pid">ID товара:</label>
    <input type="text" name="pid" placeholder="Код товара" required>
    <br>
    <label for="odate">Дата операции:</label>
    <input type="date" name="odate" placeholder="Дата операции" required>
    <br>
    <input type="submit" value="Добавить" required>
    <br><a href="http://localhost/course/users/accountant.php">Назад</a>

</form>
