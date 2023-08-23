<?php
include_once 'config.php';
// Create connection
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!$connection) {
	throw new Exception( "Cannot connect to database" );
} else{
    echo "Connected successfully";
}