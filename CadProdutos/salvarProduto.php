<?php
include('conexaoBanco/db_conexao.php'); // Conectando ao banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_categoria = $_POST['id_categoria'];
    $nome_produto = $_POST['nome_produto'];
    $descricao = $_POST['descricao'];
    $preco_produto = $_POST['preco_produto'];
    $qtd_estoque = $_POST['qtd_estoque'];

    // Inserir o produto no banco de dados
    $sql = "INSERT INTO produto (id_categoria, nome_produto, descricao, preco_produto, qtd_estoque) 
            VALUES ('$id_categoria', '$nome_produto', '$descricao', '$preco_produto', '$qtd_estoque')";
    
    if (mysqli_query($conexao, $sql)) {
        echo "Produto cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar produto: " . mysqli_error($conexao);
    }
}
?>
