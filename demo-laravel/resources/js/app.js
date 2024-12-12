require('./bootstrap');
import { Modal, Popover, Toast } from 'bootstrap';
import '../sass/app.scss';


const cards = document.querySelectorAll('.card');
let currentIndex = 0;
const descriptions = [
    "Картина, как считается, принадлежащая кисти Леонардо да Винчи. По мнению многих исследователей, это портрет Чечилии Галлерани — любовницы Лодовико Сфорца по прозванию Иль Моро, герцога Миланского, что находит подтверждение в сложной символике картины. Наряду с «Моной Лизой», «Портретом Джиневры де Бенчи» и «Прекрасной Ферроньерой» полотно принадлежит к числу четырёх женских портретов кисти Леонардо.",
    "Картина из собрания Государственного Эрмитажа в Санкт-Петербурге (инв. ГЭ-249), традиционно атрибутируемая как произведение итальянского художника и учёного эпохи Высокого Возрождения Леонардо да Винчи. Датируется периодом 1481—1495 годов. Название картины происходит от имени её последних владельцев — представителей миланского семейства графов Литта, у которых она была приобретена в российскую императорскую коллекцию в 1865 году. Техника выполнения произведения — живопись темперой на деревянной доске, в XIX веке переведённая на холст, размер полотна — 42 × 33 см[1].",
    "Илья Репин Отдых (1882) Вера Шевцова, которая в 18 лет вышла замуж за Илью Репина, была, по его же критериям, идеальной спутницей для художника: жила его интересами, увлекалась живописью, терпеливо позировала для портретов, занималась домашним хозяйством и воспитанием детей – именно с такой женщиной он мечтал оставаться до конца своих дней.",
    "Картина висела над софой, называемой летуччо. В той же комнате находились ещё две картины: «Паллада и кентавр» (1482—1483) Боттичелли и «Мадонна с Младенцем» неизвестного автора. Учитывая то обстоятельство, что 19 июля 1482 года дядя женил по политическим соображениям 17-летнего Лоренцо ди Пьерфранческо на Семирамиде, представительнице знатной фамилии Аппиани, исследователи полагают, что картина была заказана Лоренцо Великолепным Боттичелли в качестве свадебного подарка племяннику. Такие подарки были в то время обычным явлением[2].",
    "На картине изображена супруга художника Камилла с их сыном Жаном в один из ветреных летних дней периода 1871—1877 годов, когда семейство Моне проживало в Аржантёе. Мадам Моне в развевающемся на ветру белом платье и шляпе с вуалью изображена с нижнего ракурса в перспективе восходящей прямой линии на фоне облаков в лазурном небе."
];

function openModal(element) {
    const card = element.closest('.card');
    currentIndex = Array.from(cards).indexOf(card);
    updateModalContent(currentIndex);

    const modalElement = document.getElementById('imageModal');
    if (modalElement) {
        const modal = new Modal(modalElement);
        modal.show();

        document.addEventListener('keydown', handleKeydown);

        const modalDescription = document.getElementById('imageDescription');
        const popover = new Popover(modalDescription, {
            trigger: 'hover',
            content: "Это описание картинки",
            placement: 'right'
        });
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
function updateModalContent(index) {
    const card = cards[index];
    const title = card.querySelector('.card-title').textContent;
    const description = descriptions[index];
    const imageUrl = card.querySelector('.card-img-top').getAttribute('src');

    document.getElementById('imageModalLabel').textContent = title;
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('imageDescription').textContent = description;
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
    const loadButton = document.querySelector('input[type="button"]');
    loadButton.addEventListener('click', showLoadingToast);
});

document.getElementById('createPaintBtn').addEventListener('click', createPaint);
