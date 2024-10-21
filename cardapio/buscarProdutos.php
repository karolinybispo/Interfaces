<?php

   
    //verifica erros
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

include '../conexaoBanco/db_conexao.php'; // Inclua a conexão com o banco

header('Content-Type: application/json'); // Define o cabeçalho para JSON


// Consulta SQL para buscar todos os produtos 
$sql = $mySqli->prepare("SELECT img_produto, nome_produto, preco_produto FROM tb_produtos");
$sql->execute();

// Array para armazenar os produtos
$produtos = $sql->fetchAll(PDO::FETCH_ASSOC);
//retorna produtos em formato json
echo json_decode($produtos);
?>
