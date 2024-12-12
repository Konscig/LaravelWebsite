@extends('app')
@section('content')
    <div class="container">
        <h1>Детали объекта: {{ $paint->name }}</h1>

        <div class="card">
            <div class="card-header">
                <h2>Информация</h2>
            </div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $paint->id }}</p>
                <p><strong>Название:</strong> {{ $paint->paint_name }}</p>
                <p><strong>Описание:</strong> {{ $paint->description }}</p>
                <p><strong>Дата создания:</strong> {{ $paint->created_at }}</p>
                <p><strong>Дата обновления:</strong> {{ $paint->updated_at }}</p>

                @if ($paint->image_path)
                    <div class="mt-3">
                        <strong>Изображение:</strong>
                        <img src="{{ $paint->image_path }}" alt="{{ $paint->paint_name }}" class="img-fluid mt-2" style="max-width: 100%; height: auto;">

                    </div>
                @else
                    <p>Изображение не загружено.</p>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('paints.index') }}" class="btn btn-secondary">Назад к списку</a>
            <a href="{{ route('paints.edit', $paint->id) }}" class="btn btn-warning">Редактировать</a>
            <form action="{{ route('paints.destroy', $paint->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Удалить</button>
            </form>
        </div>
    </div>
@endsection
