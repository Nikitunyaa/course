<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "course";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT position FROM users WHERE login = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $position = $row["position"];

        $_SESSION["position"] = $position;

        if ($position == "admin") {
            header("Location: users/admin.php");
            exit;
        } elseif ($position == "accountant") {
            header("Location: users/accountant.php");
            exit;
        } elseif ($position == "HR") {
            header("Location: users/hr.php");
            exit;
        }
    } else {
        $error = "Неверные учетные данные. Пожалуйста, попробуйте еще раз.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <style>
       body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    background-color: #3498db; /* Синий цвет фона */
    color: #fff; /* Белый цвет текста */
}

.login-container {
    background-color: rgba(255, 255, 255, 0.8); /* Задайте цвет фона контейнера */
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    width: 300px;
}

.header {
    background-color: #2980b9; /* Синий цвет фона заголовка */
    color: white;
    padding: 15px;
    text-align: center;
}

.form-container {
    background-color: rgba(255, 255, 255, 0.8); /* Задайте цвет фона формы */
    border-radius: 8px;
    padding: 20px;
    box-sizing: border-box;
    margin: 20px;
    text-align: center;
}

label {
    font-weight: bold;
    display: block;
    margin-bottom: 8px;
    color: #555; /* Цвет текста метки */
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="submit"] {
    background-color: #2980b9; /* Синий цвет кнопки "Войти" */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #3498db; /* Синий цвет кнопки "Войти" при наведении */
}

p {
    color: red;
    text-align: center;
    margin-top: 20px;
}

    </style>
</head>

<body>
    <div class="login-container">
        <div class="header">
            <h1>Авторизация</h1>
        </div>
        <div class="form-container">
            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <label for="username">Имя пользователя:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
                <input type="submit" value="Войти">
            </form>

            <?php if (isset($error)) {
                echo "<p>$error</p>";
            } ?>
        </div>
    </div>
</body>

</html>

