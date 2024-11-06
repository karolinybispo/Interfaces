<?php
include '../conexaoBanco/db_conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['categoria'];


    // Preparar e executar a query de inserção
    $sql = "INSERT INTO categoria (nome_categoria) VALUES ('$nome')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Categoria cadastrada com sucesso!</p>";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
        echo "<p style='color: red;'>Erro ao cadastrar categoria: " . $conn->error . "</p>";
    }

    include 'cadastroCategoria.php';

    $conn->close();
}
