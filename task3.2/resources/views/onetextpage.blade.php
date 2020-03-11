@extends('layouts.app')

@section('content')

    <?php  $sum_words = 0; ?>

    <h4>Текст для анализа:</h4>
    <div class="card mb-3 p-2">
        <h5>ID текста: {{$arr_count[0]->text_id }}</h5>
        <p> {{$arr_count[0]->content }}</p>
    </div>

    <table class="table table-striped table-sm">
        <thead class="thead-dark">
        <tr>
            <th>Слово</th>
            <th>Количество вхождений</th>
        </tr>
        </thead>
        @foreach ($arr_count as $value)
            <tr>
                <td>{{$value->word}}</td>
                <td>{{$value->count}}</td>
            </tr>
            <?php $sum_words += $value->count; ?>
        @endforeach

        <tr>
            <td><b>Всего слов в тексте:<b></b></td>
            <td><b>{{$sum_words}}<b></b></td>
        </tr>
    </table>





    <br>
    <hr>
@endsection


