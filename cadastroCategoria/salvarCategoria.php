<?php
include '../conexaoBanco/db_conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['categoria'];
    $descricao = $_POST['descricao'];

    // Preparar e executar a query de inserção
    $sql = "INSERT INTO categoria (nome_categoria, descricao) VALUES ('$nome', '$descricao')";

    if ($conn->query($sql) === TRUE) {
        echo "Categoria cadastrada com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
