<main class="main">

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

            // Закрытие соединения
            $conn->close();
        ?>
    </div>

    <section class="catalog">
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

            // Фильтр по категории
            $categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';

            // SQL-запрос для получения данных о товарах и их фотографиях с учетом фильтрации
            $sql = "SELECT product.*, photo.path 
                    FROM product
                    INNER JOIN photo ON product.id_photo = photo.id_photo";

            if (!empty($categoryFilter)) {
                $sql .= " WHERE product.id_category = '$categoryFilter'";
            }

            $result = $conn->query($sql);

            // Проверка наличия данных
            if ($result->num_rows > 0) {
                // Вывод данных о товарах в виде карточек
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product">';
                    echo '<img src="' . $row['path'] . '" alt="' . $row['name'] . '">';
                    echo '<h2 class="name"><a class="name-link">' . $row['name'] . '</a></h2>';
                    echo '<p class="price">' . $row['product_price'] . ' ₽</p>';
                    echo '<button class="button-add-to-cart">Добавить в корзину</button>';
                    echo '</div>';
                }
            } else {
                echo "Нет товаров в выбранной категории.";
            }

            // Закрытие соединения
            $conn->close();
        ?>
    </section>
</main>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Информация о товаре</title>
    <!-- Здесь подключите ваши стили -->
</head>
<body>
    <main class="main">
        <div class="product-center">
            <div class="product-card">
                <?php
                    // Подключение к базе данных
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "название_вашей_базы_данных";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Получение id товара из GET-запроса (предположим, что id передается через URL)
                    $product_id = $_GET['product_id']; // Предположим, что вы передаете id товара через GET-параметр

                    // SQL-запрос для получения информации о товаре
                    $sql = "SELECT product.*, photo.path, sizes.rus_size
                            FROM product
                            INNER JOIN photo ON product.id_photo = photo.id_photo
                            INNER JOIN available_sizes ON product.id_product = available_sizes.id_product
                            INNER JOIN sizes ON available_sizes.id_sizes = sizes.id_size
                            WHERE product.id_product = $product_id";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="product-image">';
                            echo '<img src="' . $row['path'] . '" alt="product-name">';
                            echo '</div>';
                            echo '<div class="product-info">';
                            echo '<h2 class="product-name">' . $row['name'] . '</h2>';
                            echo '<p class="product-price">$' . $row['product_price'] . '</p>';
                            echo '<div class="available-sizes">';
                            echo '<ul>';
                            echo '<li>' . $row['rus_size'] . '</li>';
                            // Другие размеры могут быть добавлены аналогичным образом
                            echo '</ul>';
                            echo '</div>';
                            echo '<button class="button-add-to-cart">Добавить в корзину</button>';
                            echo '</div>';
                        }
                    } else {
                        echo "Нет информации о товаре.";
                    }
                    $conn->close();
                ?>
            </div>
        </div>
    </main>
    <!-- Здесь подключите ваши скрипты -->
</body>
</html>
