<?php
// Incluir conexão com o banco de dados
include '../conexaoBanco/db_conexao.php';

// Verificar se a requisição é do tipo POST e se as variáveis necessárias estão definidas
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_pedido']) && isset($_POST['status'])) {
    $id_pedido = intval($_POST['id_pedido']);
    $novo_status = $_POST['status'];

    // Verificar se o novo status é válido
    $status_permitidos = ['A fazer', 'Fazendo', 'Feito'];
    if (in_array($novo_status, $status_permitidos)) {
        // Atualizar o status do pedido no banco de dados
        $sql = "UPDATE pedido SET status = '$novo_status' WHERE id_pedido = $id_pedido";
        if (mysqli_query($conn, $sql)) {
            echo "Status atualizado com sucesso!";
        } else {
            echo "Erro ao atualizar o status: " . mysqli_error($conn);
        }
    } else {
        echo "Status inválido.";
    }
} else {
    echo "Dados incompletos.";
}

mysqli_close($conn);
?>
