<?php


require_once 'config.php'; // подключим настройки базы данных


function getConnDb()
{
    try {
        $conndb = new PDO("mysql:host=" . DATABASE_HOST . ";dbname=" . DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWD);
        return $conndb;
    } catch (PDOException $е) {
        // почему-то не работает PDOException $е - ругается на Undefined variable: e
        print "Не могу соединиться с базой данных: ";//. $e->getMessage();

    }

}

function getListText()
{
    try {
        $conn = getConnDb();
        $sql = "SELECT  * FROM uploaded_text  ORDER BY id DESC ";

        $st = $conn->prepare($sql);
        $st->execute();
        return ($arrListText = $st->fetchAll(PDO::FETCH_ASSOC));

    } catch (PDOException $e) {
        echo "Ошибка выполнения запроса: "; //. $e->getMessage();
    }
}

function getOneText($text_id)
{
    try {
        $conn = getConnDb();
        $sql = "SELECT  * FROM uploaded_text  JOIN  word 
                ON uploaded_text.id=word.text_id WHERE uploaded_text.id = :text_id";

        $st = $conn->prepare($sql);
        $st->execute(['text_id' => $text_id]);

        return ($arrListText = $st->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $e) {
        echo "Ошибка выполнения запроса: "; //. $e->getMessage();
    }
}

function addText($content, $arr_count)
{
    $conn = getConnDb();
    $sum_words = array_sum($arr_count);

    try {
        $sql = "INSERT  INTO uploaded_text  (id, content, words_count)
            VALUES (NULL, :content, :words_count) ";
        $st = $conn->prepare($sql);
        $st->execute(['content' => $content, 'words_count' => $sum_words]);
        $text_id = $conn->lastInsertId();

        $sql = "INSERT  INTO word  (id, text_id, word, count)
            VALUES (NULL, :text_id, :word, :count) ";

        $st = $conn->prepare($sql);
        foreach ($arr_count as $key => $value) {
            $st->execute(['text_id' => $text_id, 'word' => $key, 'count' => $value]);
        }

    } catch (PDOException $e) {
        echo "Ошибка выполнения запроса: "; //. $e->getMessage();
    }
}


?>
