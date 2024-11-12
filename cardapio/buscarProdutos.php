<?php

    //verifica erros
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

include '../conexaoBanco/db_conexao.php'; // Inclua a conexão com o banco

header('Content-Type: application/json'); // Define o cabeçalho para JSON


// Consulta SQL para buscar todos os produtos 
$sql = $conn->prepare("SELECT id_produto, foto, nome_produto, preco_produto  FROM produto");
$sql->execute();

$result = $sql->get_result();

//criando array e armazenado ent tiver valor
$produtos = [];
while ($row = $result->fetch_assoc()){
    $row['img_produto'] = 'http://localhost/interfaces/CadProdutos/uploads/' . basename($row['img_proguto']); // necessario para o navegador conseguir acessar a imagem no servidor
    $produtos[] = $row; // cada produto sera adc 
}

//converte array em json
$produtos_json = json_encode($produtos);

//exibe os produtos em formato json
header('content-type: application/json'); // define o tipo de conteudo como json
echo $produtos_json;

//fecha a declaracao
$sql->close();
$conn->close();

?>
