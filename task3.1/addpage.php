<?php
ob_start(); //без этого не работает header Location на удаленном сервере
require_once 'setup.php';



if ('POST' == $_SERVER['REQUEST_METHOD']) {

    if (isset($_FILES['exampleFile']['name']) && ($_FILES['exampleFile']['error'] == 0)) {

        $arrayFile = $_FILES['exampleFile'];
        $content = WordsText::processFile($arrayFile);
        if (!empty($content[1])) { //если при загрузке ошибки
            WordsText::showError($content[1]);
        } else {
            WordsText::writeResult($content[0]);
        }
    }

    if (isset($_POST['content'])) {
        $content = htmlentities(strip_tags($_POST['content']));
        WordsText::writeResult($content);
    }

    header("Location:index.php");
    exit;
} else {
    showHeader();
    showForm();
    showFooter();
}





