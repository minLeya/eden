// Получение всех квадратов с размерами
const sizeBoxes = document.querySelectorAll('.size-box');

// Обработчик события для каждого квадрата с размером
sizeBoxes.forEach(sizeBox => {
    sizeBox.addEventListener('click', () => {
        // Удаление класса selected у всех квадратов с размерами
        sizeBoxes.forEach(box => {
            box.classList.remove('selected');
        });

        // Применение класса selected только к выбранному квадрату
        sizeBox.classList.add('selected');
    });
});