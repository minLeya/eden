// Получите элементы для обработки события нажатия на иконку поиска
const searchIcon = document.getElementById("search-icon");
const searchInputContainer = document.getElementById("search-input-container");

// Обработчик события для отображения поля ввода и кнопки поиска
searchIcon.addEventListener("click", () => {
    searchInputContainer.style.display = "block";
});

// Добавьте обработчик события для скрытия поля ввода и кнопки поиска при нажатии на кнопку "Искать"
/* const searchButton = document.getElementById("search-button");
searchButton.addEventListener("click", () => {
    searchInputContainer.style.display = "none";
});
 */
const hamburgerButton = document.getElementById("hamburger");
const categoryMenu = document.getElementById("category");
const closeButton = document.getElementById("close");

/* 
hamburgerButton.addEventListener("click", () => {
    if (categoryMenu.style.display === "none") {
        categoryMenu.style.display = "block";
    } else {
        categoryMenu.style.display = "none";
    }
}); */

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