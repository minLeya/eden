<!-- <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eden";

// Подключение к базе данных
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных из формы
$last_name = $_POST['last_name'];
$first_name = $_POST['first_name'];
$number = $_POST['number'];
$address_id = $_POST['address'];

// Проверка номера телефона
if (strlen($number) !== 12 || substr($number, 0, 3) !== '+79') {
    echo 'Некорректный номер телефона';
    exit();
}

// Вставка данных клиента в таблицу client
$insertClientSql = "INSERT INTO client (last_name, first_name, number) VALUES ('$last_name', '$first_name', '$number')";
if ($conn->query($insertClientSql) === TRUE) {
    $client_id = $conn->insert_id; // Получение ID нового клиента
} else {
    echo "Ошибка вставки данных клиента: " . $conn->error;
    exit();
}

// Получение данных о количестве и стоимости товаров
$summarySql = "SELECT SUM(cart.quantity) AS totalQuantity, SUM(product.product_price * cart.quantity) AS totalPrice
                FROM cart
                JOIN product ON cart.id_product = product.id_product";
$resultSummary = $conn->query($summarySql);

if ($resultSummary->num_rows > 0) {
    $summary = $resultSummary->fetch_assoc();
    $totalQuantity = $summary['totalQuantity'];
    $totalPrice = $summary['totalPrice'];

    // Вставка данных в таблицу orders
    $insertOrderSql = "INSERT INTO orders (datetime, count_of_products, id_client, id_address, total) 
                    VALUES (NOW(), '$totalQuantity', '$client_id', '$address_id', '$totalPrice')";
    if ($conn->query($insertOrderSql) === TRUE) {
        $order_id = $conn->insert_id; // Получение ID нового заказа
    } else {
        echo "Ошибка вставки данных заказа: " . $conn->error;
        exit();
    }


        // Получение данных о товарах в корзине
    $cartItemsSql = "SELECT cart.*, product.product_price
        FROM cart
        JOIN product ON cart.id_product = product.id_product";
    $resultCartItems = $conn->query($cartItemsSql);

    if ($resultCartItems->num_rows > 0) {
    while ($row = $resultCartItems->fetch_assoc()) {
    $productId = $row['id_product'];
    $sizeId = $row['id_size'];
    $count = $row['quantity'];
    $productPrice = $row['product_price'];
    $sum = $count * $productPrice;

    // Вставка данных в таблицу order_details
    $insertOrderDetailsSql = "INSERT INTO order_details (id_product, id_order, id_size, count, sum) 
                            VALUES ('$productId', '$order_id', '$sizeId', '$count', '$sum')";
    if ($conn->query($insertOrderDetailsSql) !== TRUE) {
        echo "Ошибка вставки данных деталей заказа: " . $conn->error;
        exit(); }

       /*  $updateAvailableSizesSql = "UPDATE available_sizes SET count = count - '$count' WHERE id_product = '$productId' AND id_sizes = '$sizeId'";
        if ($conn->query($updateAvailableSizesSql) !== TRUE) {
            echo "Ошибка обновления данных в таблице available_sizes: " . $conn->error;
            exit();} */
            }
        } else {
            echo "Нет товаров в корзине"; }
    } else {
        echo "Нет данных о товарах";
    }

    

    $conn->close();

?>
