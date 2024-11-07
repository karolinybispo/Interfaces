<?php
ini_set('display_errors', 0);  // Desativar a exibição de erros
error_reporting(0);            // Suprimir relatórios de erro


// Conexão ao banco de dados
include '../conexaoBanco/db_conexao.php'; //arq que faz conexao com BD
        if($conn->connect_error){
            echo "Erro na conexão: " . $conn->connect_error; 
        }

header('Content-Type: application/json');

// Receber o JSON com o e-mail
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];

// Verificar se o e-mail existe no banco
$result = $conn->query("SELECT * FROM  cliente WHERE email_cliente = '$email'");
if ($result->num_rows > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'E-mail não encontrado.']);
}

$conn->close();
?>

