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
  
    // Verificar se o arquivo foi enviado corretamente
    if ($foto["error"] !== UPLOAD_ERR_OK) {
        echo "Erro no upload: " . $foto["error"];
        exit;
    }

    // Definir o diretório de destino
    $target_dir = '/Applications/XAMPP/htdocs/interfaces/CadProdutos/uploads/';

      // Criar o caminho completo do arquivo de destino
      $target_file = $target_dir . basename($foto["name"]);

        // Verificar se o arquivo é uma imagem válida
    if ($foto['tmp_name'] !== '' && getimagesize($foto['tmp_name']) !== false) {
        // Tentar mover o arquivo para o diretório de destino
        if (move_uploaded_file($foto["tmp_name"], $target_file)) {
            // O arquivo foi movido com sucesso

            // Inserir o produto no banco de dados com o caminho da imagem
            $sql = "INSERT INTO tb_produtos (id_categoria, nome_produto, descricao_produto, preco_produto, qtd_estoque_produto, img_proguto)
                    VALUES ('$id_categoria', '$nome_produto', '$descricao', '$preco_produto', '$qtd_estoque', '$target_file')";

            if ($mySqli->query($sql) === TRUE) {
                echo "<p style='color: green;'>Produto cadastrado com sucesso!</p>";
            } else {
                echo "Erro ao inserir no banco de dados: " . $mySqli->error;
            }
        } else {
            echo "Erro ao mover a imagem para o diretório." . error_get_last()['message'];
        }
    } else {
        echo "O arquivo enviado não é uma imagem ou não foi enviado corretamente.";
    }
} else {
    echo "Todos os campos do formulário são obrigatórios.";
}

include 'cadastroProdutos.php';
?>