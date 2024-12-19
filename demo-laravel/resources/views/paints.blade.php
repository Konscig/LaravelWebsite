@extends('app')

@section('content')
    <h1>Список объектов Paint</h1>
    <!-- Кнопка для открытия модального окна -->
    <a href="#" class="btn btn-primary" id="createPaintBtn">Добавить новую картину</a>
    <a href="{{ route('trashed') }}">Показать удалённые картины</a>
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
                    <form action="{{ route('paints.store') }}" method="POST" enctype="multipart/form-data" id="createPaintForm">
                        @csrf
                        <div class="mb-3">
                            <label for="paint_name" class="form-label">Название картины</label>
                            <input type="text" class="form-control" id="paint_name" name="paint_name" required>
                            @error('paint_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Описание картины</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                            @error('description')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="details" class="form-label">Детали картины</label>
                            <textarea class="form-control" id="details" name="details" required></textarea>
                            @error('details')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Изображение картины</label>
                            <input type="file" class="form-control" id="image" name="image">
                            @error('image')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary" id="createSubmitBtn" disabled>Сохранить</button>
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
                    <td class="buttons">
                        <button
                            type="button"
                            class="btn btn-info view-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#viewPaintModal-{{ $paint->id }}">
                            Просмотр
                        </button>
                        <button
                            type="button"
                            class="btn btn-warning edit-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#editPaintModal-{{ $paint->id }}">
                            Редактировать
                        </button>
                        <form action="{{ route('paints.destroy', $paint->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </form>
                    </td>
                </tr>
                <!-- Модальное окно для редактирования -->
                <div class="modal fade" id="editPaintModal-{{ $paint->id }}" tabindex="-1" aria-labelledby="editPaintModalLabel-{{ $paint->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPaintModalLabel-{{ $paint->id }}">Редактировать картину</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('paints.update', $paint->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="paint_name-{{ $paint->id }}" class="form-label">Название картины</label>
                                        <input type="text" id="paint_name-{{ $paint->id }}" name="paint_name" class="form-control" value="{{ old('paint_name', $paint->paint_name) }}" required>
                                        @error('paint_name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="description-{{ $paint->id }}" class="form-label">Описание</label>
                                        <textarea id="description-{{ $paint->id }}" name="description" class="form-control" rows="4" required>{{ old('description', $paint->description) }}</textarea>
                                        @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="details-{{ $paint->id }}" class="form-label">Детали картины</label>
                                        <textarea id="details-{{ $paint->id }}" name="details" class="form-control" rows="4">{{ old('details', $paint->details) }}</textarea>
                                        @error('details')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="image-{{ $paint->id }}" class="form-label">Изображение картины</label>
                                        <input type="file" id="image-{{ $paint->id }}" name="image" class="form-control">
                                        <small class="form-text text-muted">Оставьте поле пустым, если не хотите менять изображение.</small>
                                        @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Текущее изображение</label>
                                        <img src="{{ asset('storage/' . $paint->image_path) }}" class="img-fluid" alt="Текущее изображение">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Модальное окно для просмотра -->
                <div class="modal fade" id="viewPaintModal-{{ $paint->id }}" tabindex="-1" aria-labelledby="viewPaintModalLabel-{{ $paint->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewPaintModalLabel-{{ $paint->id }}">Просмотр картины</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Название картины</label>
                                    <input type="text" class="form-control" value="{{ $paint->paint_name }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Описание</label>
                                    <textarea class="form-control" rows="4" readonly>{{ $paint->description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Детали</label>
                                    <textarea class="form-control" rows="4" readonly>{{ $paint->details }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Изображение</label>
                                    <img src="{{ asset('storage/' . $paint->image_path) }}" class="img-fluid" alt="Изображение картины">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Дата создания</label>
                                    <input type="text" class="form-control" value="{{ $paint->created_at }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Дата изменения</label>
                                    <input type="text" class="form-control" value="{{ $paint->updated_at }}" readonly>
                                </div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
