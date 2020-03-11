
@extends('layouts.app')

@section('content')
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{$error}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
        @endforeach
    @endif

    <form method="post" action={{route('addwords')}} enctype="multipart/form-data">
        <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
        @csrf
        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />

         <div class="form-group">
            <label for="content">Введите текст для анализа:</label>
            <textarea class="form-control" rows="5" name="content"></textarea>
        </div>

        <div class="form-group">
            <label for="exampleFile">Выберите текcтовый файл для анализа (могут быть проблемы с кириллицей)</label>
            <input type="file" accept="text/plain" class="form-control-file " name="exampleFile">
        </div>
        <input type="submit" value="Обработать" class="btn btn-primary">
    </form>
<br>
<hr>

@endsection
