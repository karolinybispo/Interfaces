<?php
include '../conexaoBanco/db_conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['categoria'];


    // Preparar e executar a query de inserção
    $sql = "INSERT INTO tb_categorias (nome_categoria) VALUES ('$nome')";

    if ($mySqli->query($sql) === TRUE) {
        echo "<p style='color: green;'>Categoria cadastrada com sucesso!</p>";
    } else {
        echo "Erro: " . $sql . "<br>" . $mySqli->error;
        echo "<p style='color: red;'>Erro ao cadastrar categoria: " . $mySqli->error . "</p>";
    }

    include 'cadastroCategoria.php';

    $mySqli->close();
}
