<?php
require_once 'func_db.php';

function showHeader()
{
    print <<<HEADER
<!DOCTYPE  html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Академия разработки MediaSoft курс PHP</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="icon" href="favicon.ico" type="image/x-icon"/>
</head>

<body>

<nav class="navbar sticky-top  navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">   
     <div class="navbar-nav">
     <a class="navbar-brand" href="index.php">
    <img src="phplogo.png" width="30" height="30" alt="logo PHP">
    </a>
      <a class="nav-item nav-link active" href="index.php">Домой </a>
      <a class="nav-item nav-link active" href="addpage.php">Загрузить</a>
    </div>
  
</nav>

<div class="container" role="main">

    <h3>Задание 3. Работа с СУБД.</h3>
   
HEADER;

}

function showFooter()
{
    print <<<FOOTER
<br>
<hr>
</div>
</body>
</html>
FOOTER;

}

function showForm()
{
    print<<<_HTML_
    <form method="post" action="$_SERVER[PHP_SELF]" enctype="multipart/form-data">
        <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
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
_HTML_;

}


function showError($err)
{
    print '<div class="alert alert-danger" role="alert">';
    print $err;
    print '</div>';
}

function showListText()
{
    $arrListText = getListText();

    foreach ($arrListText as $textitem) {
        $strContent = mb_substr($textitem['content'], 0, 128) . '  [...]';
        print <<<ITEMTEXT
    <div class="card mt-3" >
     <div class="card-body ">
      <h5 class="card-title">Запись № {$textitem['id']}</h5>
      <h6 class="card-subtitle mb-2 text-muted">Количество слов: {$textitem['words_count']}</h6>
      <p class="card-text">{$strContent}</p>
      <footer class="blockquote-footer">Дата добавления {$textitem['date']}</footer>
       <a href="onetextpage.php?text_id={$textitem['id']}" class="btn btn-primary mt-2">Подробней</a>
     </div>
    </div>
ITEMTEXT;
    }


}

function showOneText($text_id)
{

    $arr_count = getOneText($text_id);
    if (!$arr_count) {
        header("Location: index.php");
    }

    $sum_words = 0;
    //Выводим текст
    print '<h5>Текст для анализа:</h5>';
    print '<div class="card mb-3 p-2">';
    print '<p>' . $arr_count[0]['content'] . '</p>';
    print '</div>';
    //выводим список слов
    print '<table class="table table-striped table-sm"><thead class="thead-dark">
        <tr> <th>Слово</th> <th>Количество вхождений</th> </tr></thead>';

    foreach ($arr_count as $value) {
        print "<tr><td>{$value['word']}</td><td>{$value['count']}</td></tr>";
        $sum_words += $value['count'];
    }

    print "<tr><td><b>Всего слов в тексте:<b></b></td><td><b>{$sum_words}<b></b></td></tr>";
    print '</table>';


}