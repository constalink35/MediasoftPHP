<?php

require_once 'func_task2.php';
require_once 'html_task2.php';

showHeader();

if ('POST' == $_SERVER['REQUEST_METHOD']) {

    if (isset($_FILES['exampleFile']['name'])&&
             ($_FILES['exampleFile']['error']==0)) {

        $arrayFile = $_FILES['exampleFile'];
        $content = processFile($arrayFile);
        writeResult($content);
    }

    if (isset($_POST['content'])) {
        $content = htmlentities(strip_tags($_POST['content']));
        writeResult($content);
    }

}

showForm();
showResultFile();
showFooter();


