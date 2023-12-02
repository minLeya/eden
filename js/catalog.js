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

