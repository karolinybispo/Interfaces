<?php
header('Content-Type: application/json');

// Conexão ao banco de dados
include '../conexaoBanco/db_conexao.php'; //arq que faz conexao com BD
        if($mySqli->connect_error){
            echo "Erro na conexão: " . $mySqli->connect_error; 
        }

// Receber o JSON com o e-mail e a nova senha
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];
$novaSenha = $data['novaSenha'];

// Atualizar a senha no banco de dados
if ($mySqli->query("UPDATE tb_clientes SET senha = '$novaSenha' WHERE email_cliente = '$email'")) {
    echo json_encode(['success' => true, 'message' => 'Senha alterada com sucesso.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao alterar a senha.']);
}

$conn->close();
?>
