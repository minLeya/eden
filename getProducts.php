<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eden";

// Создание соединения с базой данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL-запрос для получения данных о товарах
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

// Формирование данных в формате JSON
$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

// Отправляем данные в формате JSON
header('Content-Type: application/json');
echo json_encode($products);

// Закрытие соединения
$conn->close();
?>
