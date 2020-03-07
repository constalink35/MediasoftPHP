<?php
ini_set( "display_errors", true );
date_default_timezone_set("Europe/Samara");

define("DATABASE_HOST", "localhost");
define("DATABASE_NAME", "task3");
define("DATABASE_USERNAME", "root");
define("DATABASE_PASSWD", "");

function handleException( $exception ) {
  echo "Sorry, a problem occurred. Please try later.";
  error_log( $exception->getMessage() );
}

set_exception_handler( 'handleException' );

?>