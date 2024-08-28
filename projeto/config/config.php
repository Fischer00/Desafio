<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}


if (!defined('TITLE')) {
    define('TITLE', 'a v1');
}
if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
}
if (!defined('DB_USER')) {
    define('DB_USER', 'root');
}
if (!defined('DB_PASS')) {
    define('DB_PASS', '1234');
}
if (!defined('DB_SCHEMA')) {
    define('DB_SCHEMA', 'desafio');
}
if (!defined('DB_PORT')) {
    define('DB_PORT', '3306');
}


ini_set('display_errors', 1);



header('Content-Type: text/html; charset=utf-8');


$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA, DB_PORT);


if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>