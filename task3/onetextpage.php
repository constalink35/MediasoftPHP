<?php
ob_start(); //без этого почему-то не работает header Location на удаленном сервере
require_once 'func_task3.php';
require_once 'html_task3.php';

 if (isset($_GET['text_id'])) {

        showHeader();
        showOneText($_GET['text_id']);
        showFooter();

}
else{
    header("Location: index.php"); //если нет GET то на главную
    exit;
}






