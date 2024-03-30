<?php
session_start();

if ($_SESSION["position"] != "accountant") {
    header("Location: http://localhost/course/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Меню бухгалтера</title>

    <style>
        body {
            background-color: #0077cc;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        h1 {
            color: #fff;
            text-align: center;
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

        input[type="submit"] {
            background-color: #0077cc; /* Изменен цвет кнопок на синий */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            text-align: center;
        }

        input[type="submit"]:hover {
            background-color: #005a99; /* Изменен цвет при наведении */
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #fff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Меню бухгалтера</h1>
    <form action="http://localhost/course/scripts/cust_view.php" method="POST">
        <input type="submit" value="Просмотр клиентов">
    </form>
    <form action="http://localhost/course/scripts/wares.php" method="POST">
        <input type="submit" value="Приход товаров">
    </form>
    <form action="http://localhost/course/scripts/opm.php" method="POST">
        <input type="submit" value="Уход товаров">
    </form>
    <br><a href="http://localhost/course">Назад</a>
</body>
</html>
