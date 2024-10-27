<?php

    //verifica erros
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include '../conexaoBanco/db_conexao.php'; 
    
    //receber dados JSON do pedido
    $data = json_decode(file_get_contents("php://input"), true);

    //extrair dados principais do pedido
    $id_cliente = $data['id_cliente'];
    $pag_pedido = $data['pag_pedido'];
    $itens = $data['itens'];

    //inclui transacao para garantir consistencia de dados
    $mySqli->begin_transaction();

    try {
        //inserir dados na tabela PEDIDOS
        $sql = $mySqli->prepare("INSERT INTO tb_pedidos (id_cliente, status_pedido, total_pedido, data_hora_pedido, pagamento_pedido) VALUES (?, 'a fazer', 0, NOW(), ?)");
        $sql->bind_param("is", $id_cliente, $pag_pedido); // i= int, s = string. as colunas id_cliente e pagamento_pedido vao receber seus valores daqui.
        $sql->execute();

        // Obter o id_pedido gerado
        $id_pedido = $mySqli->insert_id;

        //inserir cada item na tabela ITENS
        $total_pedido = 0;
        $sql_item = $mySqli->prepare("INSERT INTO tb_itens(id_pedido, id_produto, qtd_item, preco_unita_item, sub_total) VALUES (?,?,?,?,?)");

        foreach ($itens as $item) {
            $id_produto = $item[ 'id_produto'];
            $quantidade = $item ['quantidade'];
            $preco_unita_item = $item['preco_produto'];
            $sub_total = $quantidade * $preco_unita_item;

            $total_pedido += $sub_total;

            //inserir no banco

            $sql_item->bind_param("iiidd", $id_pedido, $id_produto, $quantidade, $preco_unita_item, $sub_total);
            $sql_item->execute();
        }
            // Atualizar o total do pedido na tabela tb_pedidos
            $sql_update = $mySqli->prepare("UPDATE tb_pedidos SET total_pedido = ? WHERE id_pedido = ?");
            $sql_update->bind_param("di", $total_pedido, $id_pedido);
            $sql_update->execute();

            // Confirmar a transação
            $mySqli->commit();

            // Retornar sucesso
            echo json_encode(["success" => true]);


    }catch (Exception $e) {
        // Em caso de erro, reverter a transação
        $mySqli->rollback();
        echo json_encode(["success" => false, "message" => "Erro ao finalizar pedido: " . $e->getMessage()]);
    }
    // Fechar conexões
$sql->close();
$sql_item->close();
$sql_update->close();
$mySqli->close();



?>