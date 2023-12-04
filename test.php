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




для карточек
<?php
                // Подключение к базе данных
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "eden";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Получение id товара из GET-запроса (предположим, что id передается через URL)
                $product_id = $_GET['id_product']; // Исправлено имя переменной

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


<!-- добавление в корзину -->
$sql = "SELECT product.*, photo.path, GROUP_CONCAT(sizes.id_size) AS all_size_ids, GROUP_CONCAT(sizes.rus_size) AS all_sizes
        FROM product
        INNER JOIN photo ON product.id_photo = photo.id_photo
        INNER JOIN available_sizes ON product.id_product = available_sizes.id_product
        INNER JOIN sizes ON available_sizes.id_sizes = sizes.id_size
        WHERE product.id_product = $product_id
        GROUP BY product.id_product"; 

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sizeIds = explode(",", $row['all_size_ids']); // Получаем массив идентификаторов размеров
        $sizes = explode(",", $row['all_sizes']); // Получаем массив размеров

        // Остальная часть вывода товара
        // Ваш код для вывода изображения, названия, цены и т.д.

        echo '<div class="available-sizes">';
        
        // Цикл для добавления размеров с их идентификаторами в атрибут data-id
        for ($i = 0; $i < count($sizeIds); $i++) {
            $sizeId = $sizeIds[$i];
            $size = $sizes[$i];

            // Добавление элемента с размером и его идентификатором в атрибуте data-id
            echo '<span class="size-box" data-id="' . $sizeId . '" style="display:none;"></span>';
        }

        echo '</div>';

        // Ваш код для кнопки "Добавить в корзину"
        echo '<button class="button-add-to-cart">Добавить в корзину</button>';
        echo '</div>';
    }
} else {
    echo "Нет информации о товаре.";
}


<div class="product-info">
    <!-- ... Ваш существующий HTML код ... -->
    <form method="post" action="обработчик_добавления_в_корзину.php">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <select name="selected_size">
            <!-- Здесь можно вставить какие-то варианты выбора размера, если это необходимо -->
        </select>
        <button type="submit" name="add_to_cart">Добавить в корзину</button>
    </form>
</div>

echo '<div class="available-sizes">';
echo '<form method="post" action="addToCart.php?product_id=' . $row['id_product'] . '">';

$sizes = explode(",", $row['all_sizes']);
foreach ($sizes as $size) {
    echo '<input type="radio" id="' . trim($size) . '" name="selected_size" value="' . trim($size) . '" style="display: none;">';
    echo '<label for="' . trim($size) . '" class="size-box" style="cursor: pointer;">' . trim($size) . '</label>';
}

echo '<button type="submit" class="button-add-to-cart" name="add_to_cart">Добавить в корзину</button>';
echo '</form>';
echo '</div>';


// ... (ваш код до проверки выбранного размера)

// Выполняем проверку, выбран ли размер
if (empty($selected_size)) {
    $error_message = 'Выберите размер перед добавлением в корзину';

    
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
    $product_id = $_GET['product_id']; // Исправил: теперь берем из $_GET
    $selected_size = isset($_POST['selected_size']) ? $_POST['selected_size'] : null;

    // Проверяем, выбран ли размер
    if (empty($selected_size)) {
        echo 'Выберите размер перед добавлением в корзину';
    } else {
        // Выбранный размер не пустой - обрабатываем добавление в корзину

        // 1. Обновляем quantity в таблице cart
        $updateCartSql = "UPDATE cart SET quantity = quantity + 1 WHERE id_product = ? AND id_size = ?";
        $stmtUpdateCart = $conn->prepare($updateCartSql);
        $stmtUpdateCart->bind_param("ii", $product_id, $selected_size);

        // 2. Обновляем count в таблице available_sizes
        $updateAvailableSizesSql = "UPDATE available_sizes SET count = count - 1 WHERE id_product = ? AND id_size = ? AND count > 0";
        $stmtUpdateAvailableSizes = $conn->prepare($updateAvailableSizesSql);
        $stmtUpdateAvailableSizes->bind_param("ii", $product_id, $selected_size);

        // Запускаем оба запроса в транзакции
        $conn->begin_transaction();

        // Выполняем обновление в таблице cart
        if ($stmtUpdateCart->execute()) {
            // Выполняем обновление в таблице available_sizes
            if ($stmtUpdateAvailableSizes->execute()) {
                // Коммитим изменения в обеих таблицах
                $conn->commit();
                echo 'Товар успешно добавлен в корзину!';
            } else {
                // Ошибка в обновлении таблицы available_sizes, откатываем транзакцию
                $conn->rollback();
                echo 'Ошибка при добавлении в корзину: ' . $conn->error;
            }
        } else {
            // Ошибка в обновлении таблицы cart, откатываем транзакцию
            $conn->rollback();
            echo 'Ошибка при добавлении в корзину: ' . $conn->error;
        }

        // Закрываем соединение
        $stmtUpdateCart->close();
        $stmtUpdateAvailableSizes->close();
    }

    // Закрываем соединение с базой данных
    $conn->close();
}
?>



<!-- хз какой вариант -->

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
    $product_id = $_GET['product_id']; // Исправил: теперь берем из $_GET
    $selected_size = isset($_POST['selected_size']) ? $_POST['selected_size'] : null;

    // Проверяем, выбран ли размер
    if (empty($selected_size)) {
        echo 'Выберите размер перед добавлением в корзину';
    } else {
        // Выбранный размер не пустой - обрабатываем добавление в корзину

        // 1. Проверяем, есть ли уже товар в корзине
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

        // 2. Обновляем count в таблице available_sizes
        $updateAvailableSizesSql = "UPDATE available_sizes SET count = count - 1 WHERE id_product = ? AND id_size = ? AND count > 0";
        $stmtUpdateAvailableSizes = $conn->prepare($updateAvailableSizesSql);
        $stmtUpdateAvailableSizes->bind_param("ii", $product_id, $selected_size);

        // Запускаем оба запроса в транзакции
        $conn->begin_transaction();

        // Выполняем соответствующий запрос в таблице cart
        if (isset($stmtUpdateCart)) {
            if ($stmtUpdateCart->execute()) {
                // Выполняем обновление в таблице available_sizes
                if ($stmtUpdateAvailableSizes->execute()) {
                    $conn->commit();
                    echo 'Товар успешно добавлен в корзину!';
                } else {
                    $conn->rollback();
                    echo 'Ошибка при добавлении в корзину: ' . $conn->error;
                }
            } else {
                $conn->rollback();
                echo 'Ошибка при добавлении в корзину: ' . $conn->error;
            }
        } else {
            if ($stmtAddToCart->execute()) {
                // Выполняем обновление в таблице available_sizes
                if ($stmtUpdateAvailableSizes->execute()) {
                    $conn->commit();
                    echo 'Товар успешно добавлен в корзину!';
                } else {
                    $conn->rollback();
                    echo 'Ошибка при добавлении в корзину: ' . $conn->error;
                }
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

<!-- 03.12.2023 -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eden";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT DISTINCT cart.id_cart, product.name, product.product_price, sizes.rus_size, sizes.international_size, cart.quantity, photo.path 
        FROM cart
        JOIN product ON cart.id_product = product.id_product
        JOIN available_sizes ON cart.id_size = available_sizes.id_sizes
        JOIN sizes ON available_sizes.id_sizes = sizes.id_size
        JOIN photo ON product.id_photo = photo.id_photo";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Вывод информации о товарах в корзине
    while ($row = $result->fetch_assoc()) {
        echo '<li class="product">';
        echo '<img src="' . $row['path'] . '" alt="' . $row['name'] . '">';
        echo '<div class="product-info">';
        echo '<div class="product-details">';
        echo '<div class="product-detail-item">' . $row['name'] . '</div>';
        echo '<div class="product-detail-item">Цена: ' . $row['product_price'] . ' ₽</div>';
        echo '<div class="product-detail-item">Размер: ' . $row['rus_size'] . '(' . $row['international_size'] . ')' . '</div>';
        echo '<div class="product-detail-item">Количество: ' . $row['quantity'] . '</div>';
        echo '</div>';
        echo '<button class="delete-button" data-product-id="' . $row['id_product'] . '">Удалить</button>';
        echo '</div>';
        echo '</li>';
    } 
} else {
    echo '<div class="no-products-in-cart">В корзине нет товаров!</div>';
}
$conn->close();
?>


<!-- the best -->

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

    // Обработка удаления товара по переданным id_product и id_size
    $deleteSql = "DELETE FROM cart WHERE id_product = ? AND id_size = ?";
    $stmtDelete = $conn->prepare($deleteSql);
    $stmtDelete->bind_param("ii", $productId, $sizeId);

    if ($stmtDelete->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmtDelete->close();
    $conn->close();
}
