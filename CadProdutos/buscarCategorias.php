<?php
include '../conexaoBanco/db_conexao.php'; // Verifique se o caminho está correto

// Testando a conexão (remova o echo 'Conexão realizada' para evitar erros)
if (!$mySqli) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}

// Consultar as categorias no banco de dados
$sql = "SELECT * FROM tb_categorias";
$result = mysqli_query($mySqli, $sql);

$categorias = array();

// Preenche o array com as categorias encontradas
while ($categoria = mysqli_fetch_assoc($result)) {
    $categorias[] = $categoria;
}

// Retorna as categorias em formato JSON
header('Content-Type: application/json'); // Define o cabeçalho para JSON
echo json_encode($categorias);
?>