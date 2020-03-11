@extends('layouts.app')

@section('content')

    <div class="row">
        @foreach ($arrListText as $textitem)
            <?php    $strContent = mb_substr($textitem->content, 0, 128) . '  [...]';?>
            <div class="col-6">
                <div class="card mt-3">
                    <div class="card-body ">
                        <h5 class="card-title">Запись № {{$textitem->id}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Количество слов: {{$textitem->words_count}}</h6>
                        <p class="card-text">{{$strContent}}</p>
                        <footer class="blockquote-footer">Дата добавления {{$textitem->date}}</footer>
                        <a href="/words/{{$textitem->id}}" class="btn btn-primary mt-2">Подробней</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <br>
    <hr>
    {{$arrListText->links()}}
@endsection
