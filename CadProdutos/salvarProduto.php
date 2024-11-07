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
       $target_dir = "../imagens/";
       $target_file = $target_dir . basename($foto["name"]);
       $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
       
        // Verifica se o arquivo foi realmente enviado
        if ($foto['tmp_name'] !== '') {
            // Verifica se é uma imagem válida
            $check = getimagesize($foto["tmp_name"]);
            if ($check !== false) {
                if (move_uploaded_file($foto["tmp_name"], $target_file)) {
                    // Inserir dados no banco de dados
                    $sql = "INSERT INTO produto (id_categoria, nome_produto , descricao, preco_produto, qtd_estoque, foto)
                            VALUES ('$id_categoria', '$nome_produto', '$descricao', '$preco_produto', '$qtd_estoque', '$target_file')";
                    
                    if ($conn->query($sql) === TRUE) {
                        $mensagem = "<p style='color: green;'>Produto cadastrado com sucesso!</p>";
                    } else {
                        echo "Erro: " . $sql . "<br>" . $conn->error;
                    }
                } else {
                    echo "Erro ao enviar a imagem.";
                }
            } else {
                echo "Arquivo enviado não é uma imagem.";
            }
        } else {
            echo "Nenhum arquivo de imagem foi enviado.";
        }
    } else {
        echo "Todos os campos do formulário são obrigatórios.";
    }


$conn->close();

include 'cadastroprodutos.php';
?>
