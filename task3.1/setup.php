<?php

ini_set("display_errors", true);
date_default_timezone_set("Europe/Samara");
set_exception_handler('handleException');
require_once 'html_task3.php';



function handleException($exception)
{
    showError ( "Sorry, a problem occurred. Please try later.".$exception->getMessage());
    error_log($exception->getMessage());
}

function showError($err)
{
    print '<div class="alert alert-danger" role="alert">';
    print $err;
    print '</div>';
}

function __autoload($classname)
{
    $dir = '.' . DIRECTORY_SEPARATOR . 'classes'. DIRECTORY_SEPARATOR ;

    $filename = $dir .strtolower($classname).'.php';
    if (file_exists($filename)== false)
    {
        return false;
    }
    include $filename;
}
