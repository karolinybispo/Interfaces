<?php
include '../conexaoBanco/db_conexao.php'; // Conectando ao banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_categoria = $_POST['id_categoria'];
    $nome_produto = $_POST['nome_produto'];
    $descricao = $_POST['descricao'];
    $preco_produto = $_POST['preco_produto'];
    $qtd_estoque = $_POST['qtd_estoque'];

       // Processar upload de imagem
    $foto = $_FILES['foto'];
    $target_dir = '/Applications/XAMPP/htdocs/interfaces/CadProdutos/uploads/';
    $target_file = $target_dir . basename($foto["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      // Verifica se o arquivo é uma imagem válida
      if ($foto['tmp_name'] !== '' && getimagesize($foto['tmp_name']) !== false) {
        if (move_uploaded_file($foto["tmp_name"], $target_file)) {
            $sql = "INSERT INTO tb_produtos (id_categoria, nome_produto, descricao_produto, preco_produto, qtd_estoque_produto, img_proguto)
                    VALUES ('$id_categoria', '$nome_produto', '$descricao', '$preco_produto', '$qtd_estoque', '$target_file')";

            if ($mySqli->query($sql) === TRUE) {
                echo "<p style='color: green;'>Produto cadastrado com sucesso!</p>";
            } else {
                echo "Erro: " . $sql . "<br>" . $mySqli->error;
            }
        } else {
            echo "Erro ao mover a imagem para o diretório.";
        }
        } else {
            echo "Arquivo enviado não é uma imagem ou não foi enviado.";
        }
}        else {
            echo "Todos os campos do formulário são obrigatórios.";
}
include 'cadastroprodutos.php';
?>