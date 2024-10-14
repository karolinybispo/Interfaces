<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cantina"; // Substitua pelo nome do seu banco de dados

// Criando a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
} else {
    echo "Conexão realizada";
}
?>
