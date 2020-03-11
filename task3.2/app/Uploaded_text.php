<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uploaded_text extends Model
{
    protected $table = 'uploaded_text';
    public $timestamps = false;
    public $arr_count;


    public  function countWords($textContent)
    {
        if (isset($textContent)) {
            $content = htmlentities(strip_tags($textContent));

            //чистим текст от знаков препинания, двойных пробелов, html переводим в нижний регистр
            $content = preg_replace('#([:;!?,_()./"\'])+|(-\s+)#', ' ', $content);
            $content = preg_replace("/&#?[a-z0-9]{2,8};/i", "", $content);
            $content = mb_strtolower(trim(preg_replace('/\s\s+/', ' ', $content)));

            if (empty($content)) {
                return $arr_words = [];
            }

            $arr_words = array_count_values(explode(' ', $content));
            //сортируем по убыванию количества повторов
            arsort($arr_words);
            $this->arr_count = $arr_words;
        }
    }



//возвращает массив 1 элемент строка из содержимого файла, 2 ошибки если есть
    public static function processFile($data)
    {
        $strFile = '';
        $strErr = '';
        $fileTmp = $data['tmp_name'];
        $fileType = $data['type'];
        $fileSize = $data['size'];
        $maxfileSize = 30000;
        $errFile = $data['error'];

        // Проверяем, принят ли файл
        if (is_uploaded_file($fileTmp)) {

// Проверяем, является ли файл текстом  не пустой ли, не слишком большой;
            if (($fileType == 'text/plain') && ($fileSize > 0 && $fileSize <= $maxfileSize)) {
                $strFile = trim(htmlentities(strip_tags(file_get_contents($fileTmp))));
                unlink($fileTmp);
            } else {
                $strErr = 'Попытка добавить файл недопустимого формата и размера!';
                unlink($fileTmp);
            }
        } else {
            $strErr = "Ошибка закачки # $errFile!";
        }

        return [$strFile, $strErr];
    }


}
