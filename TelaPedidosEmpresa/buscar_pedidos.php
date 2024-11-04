<?php
include '../conexaoBanco/db_conexao.php';

$sql_pedidos = "SELECT * FROM pedido";
$result_pedidos = mysqli_query($conn, $sql_pedidos);

$pedidos = [];

while ($pedido = mysqli_fetch_assoc($result_pedidos)) {
    $pedido_id = $pedido['id_pedido'];
    
    $sql_itens = "SELECT i.qtd, i.preco_unita_item, i.sub_total, p.nome_produto 
                  FROM itens i
                  JOIN produto p ON i.id_produtos = p.id_produto
                  WHERE i.id_pedido = $pedido_id";
    $result_itens = mysqli_query($conn, $sql_itens);
    
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
