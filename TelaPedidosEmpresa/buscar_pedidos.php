<?php
include '../conexaoBanco/db_conexao.php';

$sql_pedidos = "SELECT * FROM pedido";
$result_pedidos = mysqli_query($conn, $sql_pedidos);

if (!$result_pedidos) {
    die("Erro na consulta de pedidos: " . mysqli_error($conn));
}

$pedidos = [];

while ($pedido = mysqli_fetch_assoc($result_pedidos)) {
    $pedido_id = $pedido['id_pedido'];
    $pedido['status'] = $pedido['status_pedido']; // Renomeia para 'status' para coincidir com o JavaScript
    unset($pedido['status_pedido']); // Remove o campo antigo para evitar duplicidade

    $sql_itens = "SELECT i.qtd, i.preco_unita_item, i.sub_total, p.nome_produto 
                  FROM itens i
                  JOIN produto p ON i.id_produtos = p.id_produto
                  WHERE i.id_pedido = $pedido_id";
    $result_itens = mysqli_query($conn, $sql_itens);

    if (!$result_itens) {
        die("Erro na consulta de itens: " . mysqli_error($conn));
    }

    $itens = [];
    while ($item = mysqli_fetch_assoc($result_itens)) {
        $itens[] = $item;
    }

    $pedido['itens'] = $itens;
    $pedidos[] = $pedido;
}

header('Content-Type: application/json');
echo json_encode($pedidos);

mysqli_close($conn);
?>


