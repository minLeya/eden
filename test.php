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
