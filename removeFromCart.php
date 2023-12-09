<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId']) && isset($_POST['sizeId'])) {
    $productId = $_POST['productId'];
    $sizeId = $_POST['sizeId'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "eden";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Получение текущего количества товара в корзине
    $getQuantitySql = "SELECT quantity FROM cart WHERE id_product = ? AND id_size = ?";
    $stmtGetQuantity = $conn->prepare($getQuantitySql);
    $stmtGetQuantity->bind_param("ii", $productId, $sizeId);
    $stmtGetQuantity->execute();
    $stmtGetQuantity->store_result();
    
    if ($stmtGetQuantity->num_rows > 0) {
        $stmtGetQuantity->bind_result($quantity);
        $stmtGetQuantity->fetch();

        if ($quantity > 1) {
            // Уменьшение количества на 1
            $updateSql = "UPDATE cart SET quantity = quantity - 1 WHERE id_product = ? AND id_size = ?";
            $stmtUpdate = $conn->prepare($updateSql);
            $stmtUpdate->bind_param("ii", $productId, $sizeId);
            if ($stmtUpdate->execute())
            {
                $updateAvailableSizesSql = "UPDATE available_sizes SET count = count + 1 WHERE id_product = ? AND id_sizes = ?";
                $stmtUpdateAvailableSizes = $conn->prepare($updateAvailableSizesSql);
                $stmtUpdateAvailableSizes->bind_param("ii", $productId, $sizeId);
            
                if ($stmtUpdateAvailableSizes->execute()) {
                    echo 'success';
                } else {
                    echo 'error';
                }
            }
            else {echo 'error';}
            
        } else {
            // Удаление из корзины
            $deleteSql = "DELETE FROM cart WHERE id_product = ? AND id_size = ?";
            $stmtDelete = $conn->prepare($deleteSql);
            $stmtDelete->bind_param("ii", $productId, $sizeId);
            if ($stmtDelete->execute()) {
                // Здесь вставляем код для увеличения количества в таблице available_sizes
                $updateAvailableSizesSql = "UPDATE available_sizes SET count = count + 1 WHERE id_product = ? AND id_sizes = ?";
                $stmtUpdateAvailableSizes = $conn->prepare($updateAvailableSizesSql);
                $stmtUpdateAvailableSizes->bind_param("ii", $productId, $sizeId);
            
                if ($stmtUpdateAvailableSizes->execute()) {
                    echo 'success';
                } else {
                    echo 'error';
                }
            } else {
                echo 'error';
            }
        }
    } else {
        echo 'error - product not found in cart';
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