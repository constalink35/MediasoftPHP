<?php

require_once 'html_task2.php';


function getDir(){
    //проверяем есть ли папка tmp, если нет создаем
    $dir = '.' . DIRECTORY_SEPARATOR . 'tmp';
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    return $dir. DIRECTORY_SEPARATOR ;
}

function countWords($content)
{
    //чистим текст от знаков препинания, двойных пробелов, html переводим в нижний регистр
    $content = preg_replace('#([:;!?,_()./"\'])+|(-\s+)#', ' ', $content);
    $content = preg_replace("/&#?[a-z0-9]{2,8};/i","",$content);
    $content = mb_strtolower(trim(preg_replace('/\s\s+/', ' ', $content)));

    if (empty($content)) {
        return $arr_words = [];
    }

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
        $dir = getDir();
        $fileName = uniqid('f_') . '.csv';
        //создаем файл для записи с произвольным именем
        $fp = fopen($dir . $fileName, 'w');
        foreach ($arr_count as $key => $value) {
            $row = [$key, $value];
            fputcsv($fp, $row);
        }

        //закрываем файл
        fclose($fp);
    }
}

function showResultFile()
{

    $dir = getDir();
    $files = scandir($dir);
    $arrFiles=[];
    foreach ($files as $file) {
        //выбираем только csv
        if (preg_match('/\.(csv)/', $file)) {
            $refFile = $dir . $file;
            $dateCreate = date('F d Y H:i:s', @filectime($refFile));
            $arrFiles[$file] = $dateCreate;
        }
    }
    showResultFileHTML($arrFiles);

}

//возвращает массив 1 элемент строка из содержимого файла, 2 ошибки если есть
function processFile($data){
    $strFile ='';
    $strErr = '';
    $fileTmp = $data['tmp_name'];
    $fileType = $data['type'];
    $fileSize =  $data['size'];
    $maxfileSize = 30000;
    $errFile = $data['error'];

    // Проверяем, принят ли файл
    if (is_uploaded_file($fileTmp)) {

// Проверяем, является ли файл текстом  не пустой ли, не слишком большой;
        if (($fileType == 'text/plain') && ($fileSize>0 && $fileSize<=$maxfileSize)) {
/*
            $dir = getDir();
            $fileName = $dir.uniqid('u_').'.txt';

            if(move_uploaded_file($fileTmp,$fileName)){
                //если все проверки пройдены читаем содержимое файла и
                $strFile = trim(htmlentities(strip_tags(file_get_contents($fileName))));
                unlink ($fileName);

            }else{
                $strErr = 'Ошибка копирования!';
            }
*/
            $strFile = trim(htmlentities(strip_tags(file_get_contents($fileTmp))));
            unlink ($fileTmp);
        } else {
            $strErr = 'Попытка добавить файл недопустимого формата и размера!';
            unlink ($fileTmp);
        }
    } else {
        $strErr = "Ошибка закачки # $errFile!";
    }

    return [$strFile,$strErr];
}
