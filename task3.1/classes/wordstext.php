<?php

class WordsText
{
    // не смог пока придумать как их использовать, типа ORM
    // и это у меня какой недокласс - функции обёрнутые :((
    public $id;
    public $content;
    public $date;
    public $word_count;
    public $word = [];


    public static function getListText()
    {
        $sql = "SELECT  * FROM uploaded_text  ORDER BY id DESC ";

        $st = new ConnDb();
        return $st->execute($sql);
    }

    public static function getOneText($text_id)
    {
        $sql = "SELECT  * FROM uploaded_text  JOIN  word 
                ON uploaded_text.id=word.text_id WHERE uploaded_text.id = :text_id";

        $st = new ConnDb();
        return $st->execute($sql, ['text_id' => $text_id]);

    }

    public static function addText($content, $arr_count)
    {
        $sum_words = array_sum($arr_count);

        $sql = "INSERT  INTO uploaded_text  (id, content, words_count)
            VALUES (NULL, :content, :words_count) ";

        $conn = new ConnDb();
        $conn->execute($sql, ['content' => $content, 'words_count' => $sum_words]);

        $text_id = $conn->pdo->lastInsertId();

        $sql = "INSERT  INTO word  (id, text_id, word, count)
            VALUES (NULL, :text_id, :word, :count) ";

        foreach ($arr_count as $key => $value) {
            $conn->execute($sql, ['text_id' => $text_id, 'word' => $key, 'count' => $value]);
        }

    }

    public static function countWords($content)
    {
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
        return $arr_words;

    }

    public static function writeResult($content)
    {
        //Вызываем функцию подсчета слов
        $arr_count = self::countWords($content);
        //если массив не пустой создаем файл csv в папке tmp
        if ($arr_count) {
            self::addText($content, $arr_count);
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