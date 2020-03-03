<?php
ob_start(); //без этого не работает header Location на удаленном сервере
require_once 'func_task3.php';
require_once 'html_task3.php';


if ('POST' == $_SERVER['REQUEST_METHOD']) {

    if (isset($_FILES['exampleFile']['name']) && ($_FILES['exampleFile']['error'] == 0)) {

        $arrayFile = $_FILES['exampleFile'];
        $content = processFile($arrayFile);
        if (!empty($content[1])) { //если при загрузке ошибки
            showError($content[1]);
        } else {
            writeResult($content[0]);
        }
    }

    if (isset($_POST['content'])) {
        $content = htmlentities(strip_tags($_POST['content']));
        writeResult($content);
    }

    header("Location:index.php");
    exit;
} else {
    showHeader();
    showForm();
    showFooter();
}





