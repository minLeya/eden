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

    // Получаем данные из POST запроса
    $product_id = $_GET['id_product']; // Получаем ID товара
    $selected_size = $_POST['selected_size']; // Получаем выбранный размер из формы

    // Проверяем, выбран ли размер
    if (empty($selected_size)) {
        echo 'Выберите размер перед добавлением в корзину';
    } else {
        // Выбранный размер не пустой - обрабатываем добавление в корзину

        // запрос для добавления товара в корзину
        $sql = "INSERT INTO cart (id_product, id_size, quantity) VALUES (?, ?, 1)";

        // Подготовка запроса
        $stmt = $conn->prepare($sql);

        // Привязываем параметры к запросу
        $stmt->bind_param("ii", $product_id, $selected_size);

        // Выполняем запрос
        if ($stmt->execute()) {
            echo '<script>alert("Товар успешно добавлен в корзину!");</script>';
            echo '<script>window.history.back();</script>';
            echo '<script>window.location.href = window.location.href;</script>'; // Перезагрузка страницы

        } else {
            echo 'Ошибка при добавлении в корзину: ' . $conn->error;
        }

        // Закрываем соединение
        $stmt->close();
    }

    // Закрываем соединение с базой данных
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/common.css" rel="stylesheet">
    <link href="css/card.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="img/favicon3.ico">
    <title>Информация о товаре</title>
    
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
                  </svg></a>
                </div> 

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
        <div class="product-center">
            <div class="product-card">
            
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "eden";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }


            $product_id = $_GET['id_product'];

            $sql = "SELECT product.*, photo.path, GROUP_CONCAT(available_sizes.id_sizes) AS all_size_ids, GROUP_CONCAT(sizes.rus_size) AS all_sizes
                    FROM product
                    INNER JOIN photo ON product.id_photo = photo.id_photo
                    LEFT JOIN (
                        SELECT available_sizes.id_product, available_sizes.id_sizes
                        FROM available_sizes
                        INNER JOIN sizes ON available_sizes.id_sizes = sizes.id_size
                        WHERE available_sizes.count > 0
                    ) AS available_sizes ON product.id_product = available_sizes.id_product
                    LEFT JOIN sizes ON available_sizes.id_sizes = sizes.id_size
                    WHERE product.id_product = $product_id
                    GROUP BY product.id_product"; 

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                echo '<div class="product-image">';
                echo '<img src="' . $row['path'] . '" alt="product-name">';
                echo '</div>';
                echo '<div class="product-info">';
                echo '<h2 class="product-name">' . $row['name'] . '</h2>';
                echo '<p class="product-price">' . $row['product_price'] . ' ₽</p>';

                $sizes = !empty($row['all_size_ids']) ? explode(",", $row['all_size_ids']) : [];
                $russian_sizes = !empty($row['all_sizes']) ? explode(",", $row['all_sizes']) : [];

                if (count($sizes) > 0 && count($russian_sizes) > 0) {
                    echo '<div class="available-sizes">';
                    echo '<form method="post" action="addToCart.php?product_id=' . $row['id_product'] . '">';

                    for ($i = 0; $i < count($sizes); $i++) {
                        echo '<input type="radio" id="' . trim($russian_sizes[$i]) . '" name="selected_size" value="' . trim($sizes[$i]) . '" data-id="' . trim($sizes[$i]) . '" style="display: none;">';
                        echo '<label for="' . trim($russian_sizes[$i]) . '" class="size-box" style="cursor: pointer;">' . trim($russian_sizes[$i]) . '</label>';
                    }

                    echo '<div class="button-class">';
                    echo '<button type="submit" class="button-add-to-cart" name="add_to_cart">Добавить в корзину</button>';
                    echo '</div>';

                    echo '</form>';
                    echo '</div>';
                } else {
                    echo "Нет размеров.";
                }
            } else {
                echo "Нет информации о товаре.";
            }

            $conn->close();
            ?>
            

            </div>
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

    <script src="js/card.js"></script>
    <script src="js/script.js"></script>

</body>
</html>