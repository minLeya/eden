// Получите элементы для обработки события нажатия на иконку поиска
const searchIcon = document.getElementById("search-icon");
const searchInputContainer = document.getElementById("search-input-container");

// Обработчик события для отображения поля ввода и кнопки поиска
searchIcon.addEventListener("click", () => {
    searchInputContainer.style.display = "block";
});

const hamburgerButton = document.getElementById("hamburger");
const categoryMenu = document.getElementById("category");
const closeButton = document.getElementById("close");

hamburgerButton.addEventListener("click", () => {
    const computedStyle = window.getComputedStyle(categoryMenu);
    if (computedStyle.display === "none") {
        categoryMenu.style.display = "block";
    } else {
        categoryMenu.style.display = "none";
    }
});

closeButton.addEventListener("click", () => {
    if (categoryMenu.style.display === "block") {
        categoryMenu.style.display = "none";
    } 
});


   /*  // Функция для добавления товара в корзину
    function addToCart(productId, sizeId) {
        // Определяем количество товаров (можно увеличить на 1 каждый раз при нажатии)
        var quantity = 1;

        // Отправляем AJAX-запрос на сервер для добавления в корзину
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'addToCart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Обработка ответа от сервера (если необходимо)
                console.log(xhr.responseText);
            }
        };
        // Отправляем данные о товаре и размере
        xhr.send('productId=' + productId + '&sizeId=' + sizeId + '&quantity=' + quantity);
    } */
