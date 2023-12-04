<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "eden";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Извлечение текущего значения quantity
    $getQuantitySql = "SELECT quantity FROM cart WHERE id_product = ?";
    $stmtGetQuantity = $conn->prepare($getQuantitySql);
    $stmtGetQuantity->bind_param("i", $productId);
    $stmtGetQuantity->execute();
    $stmtGetQuantity->bind_result($quantity);
    $stmtGetQuantity->fetch();
    $stmtGetQuantity->close();

    // Обновление или удаление товара
    if ($quantity > 1) {
        $updateSql = "UPDATE cart SET quantity = quantity - 1 WHERE id_product = ?";
        $stmtUpdate = $conn->prepare($updateSql);
        $stmtUpdate->bind_param("i", $productId);
        if ($stmtUpdate->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
        $stmtUpdate->close();
    } else {
        $deleteSql = "DELETE FROM cart WHERE id_product = ?";
        $stmtDelete = $conn->prepare($deleteSql);
        $stmtDelete->bind_param("i", $productId);
        if ($stmtDelete->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
        $stmtDelete->close();
    }

    $conn->close();
}
?>
