<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
      <link rel="stylesheet" href="{{ asset('css/app.css') }}">
      <script src="{{ asset('js/app.js') }}"></script>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Галерея</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </div>
        </div>

        <form class="loadbtn">
          <input type="button" value="Загрузить">
          <div class="toast-container position-fixed top-0 end-0 p-3">
              <div id="loadingToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                  <div class="toast-header">
                      <i class="fas fa-spinner fa-spin me-2"></i>
                      <strong class="me-auto">Загрузка...</strong>
                      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                  </div>
                  <div class="toast-body">
                      Пожалуйста, подождите, пока данные загружаются.
                  </div>
              </div>
          </div>
      </form>
      </nav>


      <div class="container text-center">
        <div class="row row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 d-flex align-items-stretch gy-3 my-3">
          <div class="col">
            <div class="card h-100">
              <img src="{{ asset('images/lady_with_pet.jpg') }}" class="card-img-top gallery-item" alt="...">
              <div class="card-body">
                <h5 class="card-title">Дама с питомцем</h5>
                <p class="card-text">Красивое изображение, изображающая даму с ее питомцем в спокойной обстановке.</p>
              </div>
              <div class="card-footer">
                <a href="#" class="btn btn-primary" onclick="openModal(this)">Просмотреть детали</a>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <img src="{{ asset('images/madonna_lita.jpg') }}" class="card-img-top gallery-item" alt="...">
              <div class="card-body">
                <h5 class="card-title">Мадонна Лита</h5>
                <p class="card-text">Знаменитая картина Леонардо да Винчи, изображающая Мадонну с ребёнком.</p>
              </div>
              <div class="card-footer">
                <a href="#" class="btn btn-primary" onclick="openModal(this)">Просмотреть детали</a>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <img src="{{ asset('images/resting_wife.jpg') }}" class="card-img-top gallery-item" alt="...">
              <div class="card-body">
                <h5 class="card-title">Отдыхающая жена</h5>
                <p class="card-text">Мирное изображение женщины, отдыхающей у себя дома.</p>
              </div>
              <div class="card-footer">
                <a href="#" class="btn btn-primary" onclick="openModal(this)">Просмотреть детали</a>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <img src="{{ asset('images/spring.jpg') }}" class="card-img-top gallery-item" alt="...">
              <div class="card-body">
                <h5 class="card-title">Весна</h5>
                <p class="card-text">Выражение радости и обновления во время весеннего сезона.</p>
              </div>
              <div class="card-footer">
                <a href="#" class="btn btn-primary" onclick="openModal(this)">Просмотреть детали</a>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <img src="{{ asset('images/woman_with_umbrella.jpg') }}" class="card-img-top gallery-item" alt="...">
              <div class="card-body">
                <h5 class="card-title">Женщина с зонтом</h5>
                <p class="card-text">Женщина, грациозно стоящая под зонтом под дождем.</p>
              </div>
              <div class="card-footer">
                <a href="#" class="btn btn-primary" onclick="openModal(this)">Просмотреть детали</a>
              </div>
            </div>
          </div>
        </div>
      </div>


    <!-- Модальное окно -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageModalLabel">Заголовок картинки</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <img src="" alt="" id="modalImage" class="img-fluid">
          <p id="imageDescription">Описание картинки</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <div class="centralizer">
        <div class="name">
            Герасимов Константин Сергеевич
        </div>
        <div class="icons">
            <a href="https://m.vk.com/"><img src="{{ asset('images/vk.jpg') }}" alt="Vk" class="icon"></a>
            <a href="https://web.telegram.org/"><img src="{{ asset('images/tg.jpg') }}" alt="Tg" class="icon"></a>
            <a href="https://github.com/"><img src="{{ asset('images/github.jpg') }}" alt="GitHub" class="icon"></a>
        </div>
    </div>
</footer>

    <script src="{{ asset('js/app.js') }}"></script>
  </body>
</html>
