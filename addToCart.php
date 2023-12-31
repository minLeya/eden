<?php
// Проверяем, был ли отправлен POST запрос для добавления в корзину
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {

    // Подключение к базе данных
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "eden";

    // Создание соединения
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Проверка соединения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $product_id = $_GET['product_id'];
    $selected_size = isset($_POST['selected_size']) ? $_POST['selected_size'] : null;


    // Проверяем, выбран ли размер
    if (empty($selected_size)) {
        echo '<script>alert("Выберите размер перед добавлением в корзину");</script>';
        echo '<script>window.history.back();</script>'; // Вернуться на предыдущую страницу
        exit();
    } else {
        // Выбранный размер не пустой - обрабатываем добавление в корзину
        //  Проверяем, есть ли уже товар в корзине
        $checkCartItemSql = "SELECT * FROM cart WHERE id_product = ? AND id_size = ?";
        $stmtCheckCartItem = $conn->prepare($checkCartItemSql);
        $stmtCheckCartItem->bind_param("ii", $product_id, $selected_size);
        $stmtCheckCartItem->execute();
        $result = $stmtCheckCartItem->get_result();

        if ($result->num_rows > 0) {
            // Товар уже есть в корзине, обновляем quantity
            $updateCartSql = "UPDATE cart SET quantity = quantity + 1 WHERE id_product = ? AND id_size = ?";
            $stmtUpdateCart = $conn->prepare($updateCartSql);
            $stmtUpdateCart->bind_param("ii", $product_id, $selected_size);
        } else {
            // Товара еще нет в корзине, добавляем новую запись
            $addToCartSql = "INSERT INTO cart (id_product, id_size, quantity) VALUES (?, ?, 1)";
            $stmtAddToCart = $conn->prepare($addToCartSql);
            $stmtAddToCart->bind_param("ii", $product_id, $selected_size);
        }

        //  Обновляем count в таблице available_sizes
        $updateAvailableSizesSql = "UPDATE available_sizes SET count = count - 1 WHERE id_product = ? AND id_sizes = ? AND count > 0";
        $stmtUpdateAvailableSizes = $conn->prepare($updateAvailableSizesSql);
        $stmtUpdateAvailableSizes->bind_param("ii", $product_id, $selected_size);


        // Выполняем соответствующий запрос в таблице cart
        if (isset($stmtUpdateCart)) {
            if ($stmtUpdateCart->execute() && $stmtUpdateAvailableSizes->execute()) {
                // Выполняем обновление в таблице available_sizes
               
                echo '<script>alert("Товар успешно добавлен в корзину!");</script>';
                echo '<script>window.history.back();</script>'; // Вернуться на предыдущую страницу (ВАЖНО)
/*                     echo '<script>window.location.reload();</script>'; */         
            } else {
                $conn->rollback();
                echo 'Ошибка при добавлении в корзину: ' . $conn->error;
            }
        } else {
            if ($stmtAddToCart->execute() && $stmtUpdateAvailableSizes->execute()) {
                // Выполняем обновление в таблице available_sizes
                    $conn->commit();
                    echo '<script>alert("Товар успешно добавлен в корзину!");</script>';
                    echo '<script>window.history.back();</script>';
            } else {
                $conn->rollback();
                echo 'Ошибка при добавлении в корзину: ' . $conn->error;
            }
        }

        // Закрываем соединение
        if (isset($stmtUpdateCart)) {
            $stmtUpdateCart->close();
        } elseif (isset($stmtAddToCart)) {
            $stmtAddToCart->close();
        }
        $stmtCheckCartItem->close();
        $stmtUpdateAvailableSizes->close();
    }

    // Закрываем соединение с базой данных
    $conn->close();
}
?>