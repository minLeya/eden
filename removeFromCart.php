<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId']) && isset($_POST['sizeId']) && isset($_POST['quantity'])) {
    $productId = $_POST['productId'];
    $sizeId = $_POST['sizeId'];
    $quantity = $_POST['quantity'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "eden";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Удаление из корзины
    $deleteSql = "DELETE FROM cart WHERE id_product = ? AND id_size = ?";
    $stmtDelete = $conn->prepare($deleteSql);
    $stmtDelete->bind_param("ii", $productId, $sizeId);

    if ($stmtDelete->execute()) {
        // Обновление количества в таблице available_sizes
        $updateAvailableSizesSql = "UPDATE available_sizes SET count = count + ? WHERE id_product = ? AND id_sizes = ?";
        $stmtUpdateAvailableSizes = $conn->prepare($updateAvailableSizesSql);
        $stmtUpdateAvailableSizes->bind_param("iii", $quantity, $productId, $sizeId);

        if ($stmtUpdateAvailableSizes->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo 'error';
    }

    $stmtDelete->close();
    $stmtUpdateAvailableSizes->close();
    $conn->close();
}
?>
