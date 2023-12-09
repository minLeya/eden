<!-- готово. больше не переходит после оформления заказа. очистка корзины после оформления заказа -->
<?php
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

// Проверка наличия товаров в корзине
$checkCartSql = "SELECT COUNT(*) as cartCount FROM cart";
$resultCartCount = $conn->query($checkCartSql);

if ($resultCartCount) {
    $cartCountData = $resultCartCount->fetch_assoc();
    $cartCount = $cartCountData['cartCount'];

    // Если в корзине есть товары, выполнить оформление заказа
    if ($cartCount > 0) {
        //проверка номера телефона
        if (!ctype_digit(substr($number, 3)) || strlen($number) !== 12) {
            echo '<script>alert("Неправильный ввод номера телефона!");</script>';
            echo '<script>window.history.back();</script>'; 
            exit();
        }
        
        // Проверка номера телефона
        if (substr($number, 0, 3) !== '+79') {
            echo '<script>alert("Неправильный формат номера телефона!");</script>';
            echo '<script>window.history.back();</script>'; 
            exit();
        }

        $insertClientSql = "INSERT INTO client (last_name, first_name, number) VALUES ('$last_name', '$first_name', '$number')";
        if ($conn->query($insertClientSql) === TRUE) {
            $client_id = $conn->insert_id; // Получение ID нового клиента
        } else {
            echo "Ошибка вставки данных клиента: " . $conn->error;
            exit();
        }

        //получение данных о количестве и стоимости товаров
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
            if ($conn->query($insertOrderSql) === TRUE)
            {
                $order_id = $conn->insert_id; // Получение ID нового заказа
            }
            else
            {
                echo "Ошибка вставки данных заказа: " . $conn->error;
                exit();
            }

            // Получение данных о товарах в корзине
            $cartItemsSql = "SELECT cart.*, product.product_price
            FROM cart
            JOIN product ON cart.id_product = product.id_product";
            $resultCartItems = $conn->query($cartItemsSql);

            if ($resultCartItems->num_rows > 0)
            {
                while ($row = $resultCartItems->fetch_assoc())
                {
                    $productId = $row['id_product'];
                    $sizeId = $row['id_size'];
                    $count = $row['quantity'];
                    $productPrice = $row['product_price'];
                    $sum = $count * $productPrice;

                    // Вставка данных в таблицу order_details
                    $insertOrderDetailsSql = "INSERT INTO order_details (id_product, id_order, id_size, count, sum) 
                                            VALUES ('$productId', '$order_id', '$sizeId', '$count', '$sum')";
                    if ($conn->query($insertOrderDetailsSql) !== TRUE)
                    {
                        echo "Ошибка вставки данных деталей заказа: " . $conn->error;
                        exit();
                    }
                }
            }
            else
            {
                echo "Нет товаров в корзине";
                exit();
            }

            $clearCartSql = "DELETE FROM cart";
            if (!$conn->query($clearCartSql)) {
                echo "Ошибка при очистке корзины: " . $conn->error;
            }
            else {
                echo '<script>alert("Заказ успешно оформлен!");</script>';
            }
            
        }
        else{
            echo "Нет товаров в корзине. Ошибка при получении данных о количестве и стоимости товаров.";
            exit();
        }
    

    } else { //вывод ошибки
        echo '<script>alert("Нет товаров в корзине! Оформление заказа невозможно!");</script>';
        echo '<script>window.history.back();</script>'; 
        exit();
    }
} else {
    echo "Ошибка при проверке корзины: " . $conn->error;
    exit();
}
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/common.css" rel="stylesheet">
    <link href="css/cart.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="img/favicon3.ico">
    <title>Корзина</title>
</head>
<body>
    <header class="header">
        
        <div class="container">

            <div class="hamburger" id="hamburger">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </div>
             <div class="logo-title"><a href="index.php" class="logo-link">eden</a></div>

             <div class="header-icons">
              <!--   <div class="search-input-container" id="search-input-container">
                    <input type="text" placeholder="Поиск" id="search-input" class="transparent-input">
                </div>

                <div class="search" id="search-icon"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search-heart" viewBox="0 0 16 16">
                    <path d="M6.5 4.482c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018Z"/>
                    <path d="M13 6.5a6.471 6.471 0 0 1-1.258 3.844c.04.03.078.062.115.098l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1.007 1.007 0 0 1-.1-.115h.002A6.5 6.5 0 1 1 13 6.5ZM6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11Z"/>
                  </svg>
                </div>  -->
             
                <!-- инконка корзины -->
                <div class="cart"> <a href="cart.php" class="cart-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                  </svg></a></div> 

            </div>
        </div>
    </header>

    <div class="category" id="category">

        <div class="category-icon">
            <div class="close" id="close">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                </svg>
            </div>
            <div class="logo-title"><a href="index.php" class="logo-link">eden</a></div>
        </div>

        <div class="category-text">
            <div class="category-title">Категории</div>
            <a href="catalog.php" class="category-item">Все товары</a>
        <?php
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

            // SQL-запрос для получения списка категорий
            $sql = "SELECT * FROM category";
            $result = $conn->query($sql);

            // Проверка наличия данных
            if ($result->num_rows > 0) {
                // Вывод списка категорий
                while ($row = $result->fetch_assoc()) {
                    echo '<a href="catalog.php?category=' . $row['id_category'] . '" class="category-item">' . $row['category_name'] . '</a>';
                }
            }
            $conn->close();
        ?>
        </div>
    </div>

    <main class="main">
    <h1 class="title">Корзина</h1>
       <div class="list-of-products">
            <ul>
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "eden";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = "SELECT DISTINCT cart.id_cart, product.id_product, product.name, product.product_price, sizes.id_size, sizes.rus_size, sizes.international_size, cart.quantity, photo.path 
                FROM cart
                JOIN product ON cart.id_product = product.id_product
                JOIN available_sizes ON cart.id_size = available_sizes.id_sizes
                JOIN sizes ON available_sizes.id_sizes = sizes.id_size
                JOIN photo ON product.id_photo = photo.id_photo";
        
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<li class="product">';

                        echo '<a href="card.php?id_product=' . $row['id_product'] . '" class="product-link">';
                        echo '<img src="' . $row['path'] . '" alt="' . $row['name'] . '">'; 
                        echo '</a>';

                        echo '<div class="product-info">';
                        echo '<div class="product-details">';

                        echo '<a href="card.php?id_product=' . $row['id_product'] . '" class="product-link">';
                        echo '<div class="product-detail-item">' . $row['name'] . '</div>';
                        echo '</a>';

                        echo '<div class="product-detail-item">Цена: ' . $row['product_price'] . ' ₽</div>';
                        echo '<div class="product-detail-item">Размер: ' . $row['rus_size'] . '(' . $row['international_size'] . ')' . '</div>';
                        echo '<div class="product-detail-item">Количество: ' . $row['quantity'] . '</div>';
                        echo '</div>';
                        echo '<button class="delete-button" data-product-id="' . $row['id_product'] . '" data-size-id="' . $row['id_size'] . '">Удалить</button>';
                        echo '</div>';
                        echo '</li>';
                    } 
                }
        
                else {
                    echo '<div class="no-products-in-cart">В корзине нет товаров!</div>';
                }
                $conn->close();
            ?>
            </ul>
        </div> 

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "eden";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL-запрос для получения общего количества и стоимости товаров в корзине
        $summarySql = "SELECT SUM(cart.quantity) AS totalQuantity, SUM(product.product_price * cart.quantity) AS totalPrice
                    FROM cart
                    JOIN product ON cart.id_product = product.id_product";

        $resultSummary = $conn->query($summarySql);

        if ($resultSummary->num_rows > 0) {
            $summary = $resultSummary->fetch_assoc();
            $totalQuantity = $summary['totalQuantity'];
            $totalPrice = $summary['totalPrice'];

            echo '<div class="summary">';
            echo '<p class="quantity-and-total-price">Количество <span>Общая стоимость товаров</span></p>';
            echo '<p class="quantity-and-total-price-value">' . $totalQuantity . ' ед. <span>' . $totalPrice . ' ₽</span></p>';
            echo '</div>';
        } else {
            echo '<div class="summary">';
            echo '<p class="quantity-and-total-price">Количество <span>Общая стоимость товаров</span></p>';
            echo '<p class="quantity-and-total-price-value">0 ед. <span>0 руб.</span></p>';
            echo '</div>';
        }

        $conn->close();
        ?>

        <!-- Форма для оформления заказа -->
        <div class="order-form">
            <form action="makeOrder.php" method="POST">
                <input type="text" id="last_name" name="last_name"  placeholder="Фамилия*" required><br><br>

                <input type="text" id="first_name" name="first_name" placeholder="Имя*" required><br><br>

                <input type="text" id="number" name="number" placeholder="+79123456789*" required maxlength="12"><br><br>

                <div class="address-box">
                    <select id="address" name="address" required>
                        <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "eden";

                        $conn = new mysqli($servername, $username, $password, $dbname);

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT * FROM address";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['id_address'] . '">' . $row['address'] . '</option>';
                            }
                        }
                        $conn->close();
                        ?>
                    </select><br>
                </div>
            
                <button type="submit" class="order-button">Оформить заказ</button>

            </form>
        </div>

    </main>
   
    <footer class="footer">
       <section class="help">
        <div class="help-title">Кредиты</div>
        <ul class="help-menu">
            <li class="contacts-item"><a href="https://www.flaticon.com/ru/free-icon/letter-e_5697434?term=е&page=1&position=5&origin=tag&related_id=5697434" class="contacts-link">favicon</a></li>
            <li class="contacts-item"><a href="https://zarina.ru/" class="contacts-link">photos</a></li>        </ul>
       </section>
        
       <section class="contacts">
        <div class="contacts-title">Контакты</div>
        <ul class="contacts-menu">
            <li class="contacts-item"><a href="https://t.me/sweetieleya" class="contacts-link">Telegram</a></li>

        </ul>
       </section>
    </footer>

    <script src="js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
        $('.delete-button').on('click', function() {
        var productId = $(this).data('product-id');
        var sizeId = $(this).data('size-id');

        $.ajax({
            type: 'POST',
            url: 'removeFromCart.php',
            data: { productId: productId, sizeId: sizeId },
            success: function(response) {
                if (response === 'success') {
                    location.reload();
                } else {
                    alert('Ошибка при удалении товара из корзины');
                }
            },
            error: function() {
                alert('Произошла ошибка при отправке запроса');
            }
                });
            });
        });
    </script>

</body>
</html>