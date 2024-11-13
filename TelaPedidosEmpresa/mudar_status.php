<?php
include '../conexaoBanco/db_conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_pedido']) && isset($_POST['status'])) {
    $id_pedido = intval($_POST['id_pedido']);
    $novo_status = $_POST['status'];

    $status_permitidos = ['a fazer', 'fazendo', 'feito'];
    if (in_array(strtolower($novo_status), $status_permitidos)) {
        $sql = "UPDATE pedido SET status_pedido = '$novo_status' WHERE id_pedido = $id_pedido";
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


