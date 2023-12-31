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
                                /*echo '<div class="product-detail-item">Количество: ' . $row['quantity'] . '</div>'; */

                                    echo '<div class="quantity-control">';
                                        echo '<button class="minus-button" data-product-id="' . $row['id_product'] . '" data-size-id="' . $row['id_size'] . '">-</button>';
                                        echo '<div class="product-quantity">' . $row['quantity'] . '</div>';
                                        echo '<button class="plus-button" data-product-id="' . $row['id_product'] . '" data-size-id="' . $row['id_size'] . '">+</button>';
                                    echo '</div>';
                            
                                echo '</div>';

                                echo '<button class="delete-button" data-product-id="' . $row['id_product'] . '" data-size-id="' . $row['id_size'] . '">Удалить</button>'; /* переделать так, чтобы удалял всю позицию */
                                
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

        // запрос для получения общего количества и стоимости товаров в корзине
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
                
                <div class="order-button-class">
                <button type="submit" class="order-button">Оформить заказ</button>
                </div>
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
        var quantity = $(this).siblings('.quantity-control').find('.product-quantity').text(); // Получаем количество товара

        $.ajax({
            type: 'POST',
            url: 'removeFromCart.php',
            data: { productId: productId, sizeId: sizeId, quantity: quantity }, // Добавляем quantity в данные запроса
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

<script>
    // Функция для отправки AJAX запроса на обновление количества товара
    function updateQuantity(productId, sizeId, action) {
        // Создаем объект XMLHttpRequest
        var xhr = new XMLHttpRequest();

        xhr.open("POST", "updateQuantity.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Формируем данные для отправки
        var params = "productId=" + productId + "&sizeId=" + sizeId + "&action=" + action;

        // Отправляем запрос
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if (xhr.responseText === 'success') {
                location.reload();
                } else {
                    // Если произошла ошибка
                    console.log("Ошибка при обновлении количества товара");
                }
            }
        };
        // Отправляем запрос с данными
        xhr.send(params);
    }

    // Обработчики для кнопок "+" и "-"
    document.querySelectorAll('.minus-button').forEach(function (button) {
        button.addEventListener('click', function () {
            var productId = button.dataset.productId;
            var sizeId = button.dataset.sizeId;
            updateQuantity(productId, sizeId, 'decrement');
        });
    });

    document.querySelectorAll('.plus-button').forEach(function (button) {
        button.addEventListener('click', function () {
            var productId = button.dataset.productId;
            var sizeId = button.dataset.sizeId;
            updateQuantity(productId, sizeId, 'increment');
        });
    });
</script>


</body>
</html>