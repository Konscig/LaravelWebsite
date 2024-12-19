@extends('app')

@section('content')
    <h1>Удалённые картины</h1>
    @if($trashedPaints->isEmpty())
        <p>Нет удалённых картин.</p>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Название</th>
                <th>Описание</th>
                <th>Детали</th>
                <th>Изображение</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($trashedPaints as $paint)
                <tr>
                    <td>{{ $paint->paint_name }}</td>
                    <td>{{ $paint->description }}</td>
                    <td>{{ $paint->details }}</td>
                    <td>
                        @if($paint->image_path)
                            <img src="{{ asset('storage/'. $paint->image_path) }}" alt="Изображение" width="100">
                        @else
                            Нет изображения
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('paints.forceDelete', $paint->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Удалить навсегда</button>
                        </form>
                        <form action="{{ route('paints.restore', $paint->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary">Восстановить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
