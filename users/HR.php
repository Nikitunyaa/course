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
    <title>Меню HR</title>
    <style>
        body {
            background-color: #3498db;
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        h1 {
            color: #fff; /* Белый цвет заголовка */
            text-align: center;
            margin-top: 50px;
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

        input[type="submit"] {
            background-color: #0077cc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #27ae60;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #fff; /* Белый цвет текста ссылки */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Меню HR</h1>
    <form action="http://localhost/course/scripts/hrm.php" method="POST">
        <input type="submit" value="Работа с клиентами">
    </form>
    <form action="http://localhost/course/scripts/worker.php" method="POST">
        <input type="submit" value="Работа с сотрудниками">
    </form>
    <a href="http://localhost/course">Назад</a>
</body>

</html>
