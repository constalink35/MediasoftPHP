<?php

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


<div class="container" role="main">
    <h3>Задание 2. Формы и файлы.</h3>
   <ul>
     <li><p>Добавить на страницу форму с как минимум одним текстовым и одним файловым полем.
    Обрабатывать текст взависимости от поля которое было заполнено, если оба поля были
    заполнены необходимо обработать каждое из них.</p></li>
    
    
        <li>результат обработки каждого поля сохранить в отдельный *.csv файл 
        (если поле не заполнено файл создаваться не должен)</li>
        <li>результатом каждого запуска скрипта должны являтся новые файлы 
        (старые файлы не должны быть перезаписаны)</li>
        
    </ul>
HEADER;

}

function showFooter() {
print <<<FOOTER
<br>
<hr>
</div>
</body>
</html>
FOOTER;

}

function showForm(){
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


function showResultFileHTML($files){
    //Выводим Список файлов c результатами
    print '<h5>Список файлов c результатами:</h5>';

    print '<table class="table table-striped table-sm"><thead class="thead-dark">
        <tr> <th>Файл</th> <th>Создан</th></tr></thead>';

    foreach ($files as $file=>$dateCreate){
        $dir = getDir();
        $refFile= $dir.$file;
        print "<tr><td><a href='$refFile'>$file</a></td> <td>$dateCreate</td> </tr>";
    }

    print '</table>';
}

function showError($err){
    print '<div class="alert alert-danger" role="alert">';
    print $err;
    print '</div>';
}
