<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId']) && isset($_POST['sizeId']) && isset($_POST['action'])) {
    $productId = $_POST['productId'];
    $sizeId = $_POST['sizeId'];
    $action = $_POST['action'];

    // Подключение к базе данных
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "eden";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($action === 'increment') {
        // Увеличение количества в корзине
        $updateCartSql = "UPDATE cart SET quantity = quantity + 1 WHERE id_product = ? AND id_size = ?";
        $stmtUpdateCart = $conn->prepare($updateCartSql);
        $stmtUpdateCart->bind_param("ii", $productId, $sizeId);
        $stmtUpdateCart->execute();
        $stmtUpdateCart->close();

        // Уменьшение количества доступных товаров
        $updateAvailableSizesSql = "UPDATE available_sizes SET count = count - 1 WHERE id_product = ? AND id_sizes = ?";
        $stmtUpdateAvailableSizes = $conn->prepare($updateAvailableSizesSql);
        $stmtUpdateAvailableSizes->bind_param("ii", $productId, $sizeId);
        $stmtUpdateAvailableSizes->execute();
        $stmtUpdateAvailableSizes->close();

        echo 'success';
    } elseif ($action === 'decrement') {
        // Уменьшение количества в корзине
        $updateCartSql = "UPDATE cart SET quantity = CASE WHEN quantity > 1 THEN quantity - 1 ELSE 1 END WHERE id_product = ? AND id_size = ?";
        $stmtUpdateCart = $conn->prepare($updateCartSql);
        $stmtUpdateCart->bind_param("ii", $productId, $sizeId);
        $stmtUpdateCart->execute();
        $stmtUpdateCart->close();
        

        // Увеличение количества доступных товаров
        $updateAvailableSizesSql = "UPDATE available_sizes SET count = count + 1 WHERE id_product = ? AND id_sizes = ?";
        $stmtUpdateAvailableSizes = $conn->prepare($updateAvailableSizesSql);
        $stmtUpdateAvailableSizes->bind_param("ii", $productId, $sizeId);
        $stmtUpdateAvailableSizes->execute();
        $stmtUpdateAvailableSizes->close();

        echo 'success';
    }

    $conn->close();
}
?>
