<?php

// Подключение к базе данных
session_start();

if ($_SESSION["position"] != "accountant") {
    header("Location: http://localhost/course/index.php");
    return;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "course";

$conn = new mysqli($servername, $username, $password, $dbname);

$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Создаем переменные для хранения данных из формы
$amt = $_POST['amt'];
$cid = $_POST['cid'];
$pid = $_POST['pid'];
$odate = $_POST['odate'];

// Проверяем, что поле amt не превышает аналогичное поле в таблице warehouse
$query = "SELECT amt FROM warehouse WHERE cid = ? AND pid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $cid, $pid);
$stmt->execute();
$stmt->bind_result($warehouseAmt);
$stmt->fetch();
$stmt->close();

if ($amt > $warehouseAmt) {
    echo "Ошибка, проверьте остатки на складе и id.";
    echo '<br><button onclick="document.location=\'http://localhost/course/scripts/opm.php\'">Назад</button>';
    return;
}

if($amt == $warehouseAmt) {
    $query = "DELETE FROM warehouse WHERE cid = ? AND pid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $cid, $pid);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();
}else{
    // Обновляем количество товара на складе
    $query = "UPDATE warehouse SET amt = amt - ? WHERE cid = ? AND pid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $amt, $cid, $pid);
    $stmt->execute();
    $stmt->close();
}
// Добавляем запись в таблицу operations
$query = "INSERT INTO operations (amt, cid, pid, odate) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iiis", $amt, $cid, $pid, $odate);
$stmt->execute();
$stmt->close();

// Выводим сообщение об успешном выполнении скрипта
echo "Запись успешно добавлена.";
echo '<br><button onclick="document.location=\'http://localhost/course/scripts/opm.php\'">Назад</button>';

$conn->close();
?>
