<?php
include '../conexaoBanco/db_conexao.php'; // Inclua a conexão com o banco

// Verifique a conexão
if (!$conn) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}

// Consulta SQL para buscar todos os produtos e suas respectivas categorias
$sql = "SELECT p.nome_produto, p.descricao, p.preco_produto, c.nome_categoria 
        FROM produto p 
        JOIN categoria c ON p.id_categoria = c.id_categoria";
$result = mysqli_query($conn, $sql);

// Array para armazenar os produtos
$produtos = array();

// Preenche o array com os dados dos produtos
while ($produto = mysqli_fetch_assoc($result)) {
    $produtos[] = $produto;
}

// Retorna os produtos em formato JSON
header('Content-Type: application/json'); // Define o cabeçalho para JSON
echo json_encode($produtos);
?>
