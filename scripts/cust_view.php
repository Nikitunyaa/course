<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
if ($_SESSION["position"] != "accountant" && $_SESSION["position"] != "admin" && $_SESSION["position"] != "HR") {
    header("Location: http://localhost/course/index.php");
    exit;
}
?>

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
        border-collapse: collapse;
        margin: 20px auto;
        font-size: 1.2em;
        min-width: 90%;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    }

    table th,
    table td {
        padding: 8px 5px;
    }

    table th {
        background-color: #004080;
        color: white;
        text-align: center;
    }

    table tr:nth-of-type(even) {
        background-color: #005a99;
    }

    table tr:hover {
        background-color: #005a99;
    }

    table td:last-child {
        text-align: center;
    }

    table input[type="text"] {
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 3px;
        width: 100%;
        box-sizing: border-box;
    }

    table select {
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 3px;
        width: 100%;
        box-sizing: border-box;
    }

    table input[type="submit"] {
        background-color: #004080;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    table input[type="submit"]:hover {
        background-color: #002b4d;
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

    select {
        width: 70%;
        padding: 5px;
        border-radius: 2px;
        border: 2px solid #004080;
        margin-bottom: 10px;
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

<?php
echo '<h1>Мои клиенты</h1>';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "course";

// Создаем подключение
$conn = new mysqli($servername, $username, $password, $dbname);

mysqli_set_charset($conn, "utf8");

// Проверяем подключение
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Выполняем SQL запрос для получения данных из таблицы "customers"
$sql = "SELECT cid, cname, city FROM customers";
$result = $conn->query($sql);

// Проверяем, есть ли данные
if ($result->num_rows > 0) {
    // Создаем таблицу
    echo "<table border=1><tr><th>ID</th><th>Name</th><th>City</th></tr>";
    // Выводим данные каждой строки
    while($row = $result->fetch_assoc()) {
        // Заполняем таблицу данными
        echo "<tr><td>" . $row["cid"]. "</td><td>" . $row["cname"]. "</td><td>" . $row["city"]. "</td></tr>";
    }
    // Закрываем таблицу
    echo "</table>";
}
else {
    echo "0 результатов";
}

// Закрываем подключение
$conn->close();
echo'<a href="javascript:history.back()">Назад</a>';
?>
