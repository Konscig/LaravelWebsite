@extends('app')

@section('content')
    <h1>Список объектов Paint</h1>
    <!-- Кнопка для открытия модального окна -->
    <a href="#" class="btn btn-primary" id="createPaintBtn">Добавить новую картину</a>

    <!-- Модальное окно -->
    <div class="modal fade" id="createPaintModal" tabindex="-1" aria-labelledby="createPaintModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPaintModalLabel">Создание новой картины</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Форма для добавления картины -->
                    <form action="{{ route('paints.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="paint_name" class="form-label">Название картины</label>
                            <input type="text" class="form-control" id="paint_name" name="paint_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Описание картины</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="details" class="form-label">Детали картины</label>
                            <textarea class="form-control" id="details" name="details" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Изображение картины</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @if ($paints->isEmpty())
        <p>Нет данных для отображения.</p>
    @else
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Дата создания</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($paints as $paint)
                <tr>
                    <td>{{ $paint->id }}</td>
                    <td>{{ $paint->paint_name }}</td>
                    <td>{{ $paint->description }}</td>
                    <td>{{ $paint->created_at }}</td>
                    <td>
                        <a href="{{ route('paints.show', $paint->id) }}" class="btn btn-info">Просмотр</a>
                        <a href="{{ route('paints.edit', $paint->id) }}" class="btn btn-warning">Редактировать</a>
                        <form action="{{ route('paints.destroy', $paint->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
