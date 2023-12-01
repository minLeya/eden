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
                <!-- поле поиска -->
                <div class="search-input-container" id="search-input-container">
                    <input type="text" placeholder="Поиск" id="search-input" class="transparent-input">
                    <!-- <button id="search-button">Искать</button> -->
                </div>

                <!-- иконка  поиска-->
                <div class="search" id="search-icon"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search-heart" viewBox="0 0 16 16">
                    <path d="M6.5 4.482c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018Z"/>
                    <path d="M13 6.5a6.471 6.471 0 0 1-1.258 3.844c.04.03.078.062.115.098l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1.007 1.007 0 0 1-.1-.115h.002A6.5 6.5 0 1 1 13 6.5ZM6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11Z"/>
                  </svg>
                </div> 
             
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

            <div class="logo-title"><a href="index.html" class="logo-link">eden</a></div>

        </div>

        <div class="category-text">
            <div class="category-title">Категории</div>
            <a href="catalog.php" class="category-item">Рубашки</a>
            <a href="" class="category-item">Футболки</a>
            <a href="" class="category-item">Кофты</a>
        </div>
        
    </div>

    <main class="main">
    <h1 class="title">Корзина</h1>
       <div class="list-of-products">
            <ul>
            <li class="product">
                <img src="img/top.jpg" alt="Product Image">
                <div class="product-info">
                    <div class="product-details">
                        <p>Цена: $50</p>
                        <p>Размер: S</p>
                        <p>Количество: 2</p>
                    </div>
                    <button>Удалить</button>
                </div>
            </li>
            <li class="product">
                <img src="path/to/image2.jpg" alt="Product Image">
                <div class="product-info">
                    <div class="product-details">
                        <p>Цена: $40</p>
                        <p>Размер: M</p>
                        <p>Количество: 1</p>
                    </div>
                    <button>Удалить</button>
                </div>
            </li>
            </ul>
        </div> 
       <!--  <h1 class="title">Корзина</h1>
    
        <div class="cart-items">
            <div class="cart-item">
                <img src="path/to/image1.jpg" alt="Product Image">
                <div class="cart-item-details">
                    <p class="product-name">Название продукта</p>
                    <p class="product-price">$50</p>
                    <div class="product-quantity">
                        <button class="quantity-btn">-</button>
                        <span class="quantity">2</span>
                        <button class="quantity-btn">+</button>
                    </div>
                    <div class="product-size">
                        <label for="size">Размер:</label>
                        <select id="size">
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                        </select>
                    </div>
                </div>
                <button class="remove-btn">Удалить</button>
            </div>
        </div> -->
      
    </main>
   
    <footer class="footer">
       
       <section class="help">
        <div class="help-title">Помощь</div>
        <ul class="help-menu">
            <li class="help-item"><a href="#" class="help-link">Покупка</a></li>
            <li class="help-item"><a href="#" class="help-link">Магазины</a></li>
        </ul>
       </section>
        
       <section class="contacts">
        <div class="contacts-title">Контакты</div>
        <ul class="contacts-menu">
            <li class="contacts-item"><a href="#mytg" class="contacts-link">Telegram</a></li>
            <li class="contacts-item"><a href="https://www.flaticon.com/ru/free-icons/-n" class="contacts-link">favicon</a></li>
        </ul>
       </section>
       
    </footer>

    <script src="js/catalog.js"></script>
</body>
</html>
