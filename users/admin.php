<?php
session_start();

if ($_SESSION["position"] != "admin") {
    header("Location: http://localhost/course/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Меню администратора</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #3498db; /* Синий цвет фона */
            color: #fff; /* Белый цвет текста */
        }

        .menu-container {
            background-color: rgba(255, 255, 255, 0.8); /* Цвет фона контейнера меню */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px;
            text-align: center;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-top: 10px;
        }

        form {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        input[type="submit"] {
            background-color: #3498db; /* Синий цвет кнопки "Работа с пользователями" */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        input[type="submit"]:hover {
            background-color: #2980b9; /* Синий цвет кнопки при наведении */
        }

        a {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #333;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="menu-container">
        <h1>Меню администратора</h1>
        <form action="http://localhost/course/scripts/adminm.php" method="POST">
            <input type="submit" value="Работа с пользователями">
        </form>
        <br><a href="http://localhost/course">Назад</a>
    </div>
</body>

</html>

