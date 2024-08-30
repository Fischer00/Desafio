<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}


if (!defined('TITLE')) {
    define('TITLE', 'a v1');
}
if (!defined('DB_HOST')) {
    define('DB_HOST', 'DB_HOST');
}
if (!defined('DB_USER')) {
    define('DB_USER', 'DB_USER');
}
if (!defined('DB_PASS')) {
    define('DB_PASS', 'DB_PASS');
}
if (!defined('DB_SCHEMA')) {
    define('DB_SCHEMA', 'DB_SCHEMA');
}
if (!defined('DB_PORT')) {
    define('DB_PORT', 'DB_PORT');
}


ini_set('display_errors', 1);



header('Content-Type: text/html; charset=utf-8');


$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA, DB_PORT);


if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>