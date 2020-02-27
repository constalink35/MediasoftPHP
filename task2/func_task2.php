<?php


function countWords($content)
{
    //чистим текст от знаков препинания, двойных пробелов, html переводим в нижний регистр
    $content = preg_replace('#([:;!?,_()./"\'])+|(-\s+)#', ' ', $content);
    $content = preg_replace("/&#?[a-z0-9]{2,8};/i","",$content);
    $content = mb_strtolower(trim(preg_replace('/\s\s+/', ' ', $content)));

    if (empty($content)) return $arr_words = [];

    $arr_words = array_count_values(explode(' ', $content));
    //сортируем по убыванию количества повторов
    arsort($arr_words);
    return $arr_words;

}

function writeResult($content){

//Вызываем функцию подсчета слов
    $arr_count = countWords($content);
    //если массив не пустой создаем файл csv в папке tmp
    if ($arr_count) {
        $dir = '.' . DIRECTORY_SEPARATOR . 'tmp';
        $fileName = uniqid('f_') . '.csv';
        //создаем файл для записи с произвольным именем
        $fp = fopen($dir . DIRECTORY_SEPARATOR . $fileName, 'w');
        foreach ($arr_count as $key => $value) {
            $row = array($key, $value);
            fputcsv($fp, $row);
        }

        //закрываем файл
        fclose($fp);
    }
}

function showResultFile(){
    //Выводим Список файлов c результатами
    print '<h5>Список файлов c результатами:</h5>';


    print '<table class="table table-striped table-sm"><thead class="thead-dark">
        <tr> <th>Файл</th> <th>Создан</th></tr></thead>';

    $dir = '.'.DIRECTORY_SEPARATOR.'tmp';
    $files = scandir($dir);
    foreach ($files as $file){
        //выбираем только csv
        if(preg_match('/\.(csv)/', $file)){
            $refFile= $dir.DIRECTORY_SEPARATOR.$file;
            $dateCreate = date('F d Y H:i:s', @filectime($refFile));
            print "<tr><td><a href='$refFile'>$file</a></td> <td>$dateCreate</td> </tr>";
        }
    }
    print '</table>';
}

function processFile($data){
    $strFile ='';
    $fileTmp = $data['tmp_name'];
    $fileType = $data['type'];
    $fileSize =  $data['size'];
    $maxfileSize = 30000;
    $errFile = $data['error'];

    // Проверяем, принят ли файл
    if (is_uploaded_file($fileTmp)) {

// Проверяем, является ли файл текстом  не пустой ли, не слишком большой;
        if (($fileType == 'text/plain') && ($fileSize>0 && $fileSize<=$maxfileSize)) {

            $dir = '.'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR;
            $fileName = $dir.uniqid('u_').'.txt';

            if(move_uploaded_file($fileTmp,$fileName)){
                //если все проверки пройдены читаем содержимое файла и
                $strFile = trim(htmlentities(strip_tags(file_get_contents($fileName))));
                unlink ($fileName);

            }else{
                echo "<h2>Ошибка копирования!</h2>";
            }

        } else {
            echo "<h2>Попытка добавить файл недопустимого формата и размера!</h2>";
            unlink ($fileTmp);
        }
    } else {
        echo "<h2>Ошибка закачки # $errFile!</h2>";
    }

    return $strFile;
}
