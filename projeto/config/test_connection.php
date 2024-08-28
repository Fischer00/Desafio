<?php
// Defina as constantes de conexão com o banco de dados
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '1234');
define('DB_SCHEMA', 'desafio');
define('DB_PORT', '3306');

// Tente conectar ao banco de dados
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA, DB_PORT);

// Verifique a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
} else {
    echo "Conexão bem-sucedida!";
}

// Feche a conexão
$conn->close();
?>
