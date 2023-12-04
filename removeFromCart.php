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

    // Получение текущего количества
    $getQuantitySql = "SELECT quantity FROM cart WHERE id_product = ?";
    $stmtGetQuantity = $conn->prepare($getQuantitySql);
    $stmtGetQuantity->bind_param("i", $productId);
    $stmtGetQuantity->execute();
    $stmtGetQuantity->bind_result($quantity);
    $stmtGetQuantity->fetch();

    if ($quantity > 1) {
        // Уменьшение количества на 1
        $updateSql = "UPDATE cart SET quantity = quantity - 1 WHERE id_product = ?";
        $stmtUpdate = $conn->prepare($updateSql);
        $stmtUpdate->bind_param("i", $productId);
        if ($stmtUpdate->execute()) {
            echo 'success - quantity updated';
        } else {
            echo 'error - quantity update';
        }
    } else {
        // Удаление из корзины
        $deleteSql = "DELETE FROM cart WHERE id_product = ?";
        $stmtDelete = $conn->prepare($deleteSql);
        $stmtDelete->bind_param("i", $productId);
        if ($stmtDelete->execute()) {
            echo 'success - product deleted';
        } else {
            echo 'error - product deletion';
        }
    }

    $stmtGetQuantity->close();
    if (isset($stmtUpdate)) {
        $stmtUpdate->close();
    }
    if (isset($stmtDelete)) {
        $stmtDelete->close();
    }
    $conn->close();
}
?>
