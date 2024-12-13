require('./bootstrap');
import { Modal, Popover, Toast } from 'bootstrap';
import '../sass/app.scss';

let cards = document.querySelectorAll('.card'); // Список всех карточек
let currentIndex = 0; // Индекс текущей карточки

function openModal(element) {
    // Найти карточку, к которой относится кнопка
    const card = element.closest('.card');
    if (card) {
        // Получить заголовок, изображение и описание из карточки
        const title = card.querySelector('.card-title').textContent;
        const imageSrc = card.querySelector('.card-img-top').src;
        const description = card.querySelector('.card-text').textContent;
        const cardId = card.getAttribute('data-id'); // Предполагаем, что ID карточки хранится в data-id

        // Получить details с сервера
        fetch(`/card/${cardId}/details`)
            .then(response => response.json())
            .then(data => {
                if (data.details) {
                    // Обновить содержимое модального окна
                    document.getElementById('imageModalLabel').textContent = title;
                    document.getElementById('modalImage').src = imageSrc;
                    document.getElementById('imageDescription').textContent = description;
                    document.getElementById('imageDetails').textContent = data.details; // Устанавливаем details
                } else {
                    console.error('Details not found');
                }
            })
            .catch(error => console.error('Error fetching details:', error));
    }

    // Показать модальное окно
    const modalElement = document.getElementById('imageModal');
    if (modalElement) {
        const modal = new Modal(modalElement);
        modal.show();
    }
}
function updateModalContent(index) {
    const card = cards[index];
    const title = card.querySelector('.card-title').textContent;
    const description = card.querySelector('.card-text').textContent;
    const details = card.querySelector('.card-description').textContent; // Если описание хранится в отдельном элементе
    const imageUrl = card.querySelector('.card-img-top').getAttribute('src'); // Ссылка на изображение

    // Обновляем модальное окно
    document.getElementById('imageModalLabel').textContent = title;
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('imageDescription').textContent = description;
    document.getElementById('imageDetails').textContent = details;

    // Показать модальное окно
    const modalElement = document.getElementById('imageModal');
    if (modalElement) {
        const modal = new Modal(modalElement);
        modal.show();

        // Добавить обработчик для закрытия модального окна на Escape
        const handleKeydown = (event) => {
            if (event.key === 'Escape') {
                modal.hide();
                document.removeEventListener('keydown', handleKeydown);
            }
        };

        document.addEventListener('keydown', handleKeydown);

        // Добавить popover к описанию
        const modalDescription = document.getElementById('imageDescription');
        if (modalDescription) {
            const popover = new Popover(modalDescription, {
                trigger: 'hover',
                content: "Это описание картинки",
                placement: 'right'
            });
        }
    }
}

function createPaint(event) {
    // Прекращаем стандартное поведение ссылки
    event.preventDefault();

    // Получаем объект модального окна Bootstrap
    const myModal = new Modal(document.getElementById('createPaintModal'));

    // Показываем модальное окно
    myModal.show();
}

function viewPaint(event, paintId) {
    // Прекращаем стандартное поведение ссылки
    event.preventDefault();

    // Получаем объект модального окна Bootstrap по ID
    const myModal = new Modal(document.getElementById('viewPaintModal-' + paintId));

    // Показываем модальное окно
    myModal.show();
}

function handleKeydown(event) {
    const totalCards = cards.length;
    if (event.key === 'ArrowRight') {
        currentIndex = (currentIndex + 1) % totalCards;
        updateModalContent(currentIndex);
    } else if (event.key === 'ArrowLeft') {
        currentIndex = (currentIndex - 1 + totalCards) % totalCards;
        updateModalContent(currentIndex);
    } else if (event.key === 'Escape') {
        const modalElement = document.getElementById('imageModal');
        const modal = Modal.getInstance(modalElement);
        modal.hide();
        document.removeEventListener('keydown', handleKeydown);
    }
}

window.openModal = openModal;

function showLoadingToast() {
    const toastElement = document.getElementById('loadingToast');
    const toast = new Toast(toastElement);
    toast.show();
}

document.addEventListener('DOMContentLoaded', () => {
    const loadButton = document.querySelector('#createPaintButton');
    loadButton.addEventListener('click', showLoadingToast);
});

document.getElementById('createPaintBtn').addEventListener('click', createPaint);
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        const targetModalId = button.getAttribute('data-bs-target').substring(1); // Убираем префикс #
        viewPaint(event, targetModalId);
    });
});

document.addEventListener('DOMContentLoaded', () => {
    // Валидация формы для создания картины
    const createForm = document.querySelector('#createPaintModal form');
    const createInputs = createForm.querySelectorAll('input, textarea');
    const createSubmitButton = createForm.querySelector('button[type="submit"]');

    setupValidation(createForm, createInputs, createSubmitButton);

    // Валидация форм для редактирования картин
    const editForms = document.querySelectorAll('[id^="editPaintModal-"] form');
    editForms.forEach(editForm => {
        const editInputs = editForm.querySelectorAll('input, textarea');
        const editSubmitButton = editForm.querySelector('button[type="submit"]');
        setupValidation(editForm, editInputs, editSubmitButton);
    });
});

/**
 * Устанавливает валидацию для формы
 * @param {HTMLFormElement} form - Форма для проверки
 * @param {NodeList} inputs - Поля формы
 * @param {HTMLButtonElement} submitButton - Кнопка отправки
 */
function setupValidation(form, inputs, submitButton) {
    form.addEventListener('submit', (event) => {
        let isValid = true;

        inputs.forEach(input => {
            if (!input.checkValidity()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            event.preventDefault(); // Остановить отправку формы
            event.stopPropagation();
        }
    });

    inputs.forEach(input => {
        input.addEventListener('input', () => {
            if (input.checkValidity()) {
                input.classList.remove('is-invalid');
            }
        });
    });

    // Деактивация кнопки отправки, пока форма не валидна
    form.addEventListener('input', () => {
        let allValid = true;

        inputs.forEach(input => {
            if (!input.checkValidity()) {
                allValid = false;
            }
        });

        submitButton.disabled = !allValid;
    });
}
