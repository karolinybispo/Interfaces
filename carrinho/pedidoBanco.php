<?php
    //verifica erros
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    
    // Receber dados JSON do pedido
    $data = json_decode(file_get_contents("php://input"), true);
    //extraindo dados do pedido vindos do json
    $id_cliente = $data['id_cliente'];
    $Total_pedido =$data['total']; 
    $pag_pedido = $data['pagamento_pedido'];
    $itens = $data['itens'];

    include '../conexaoBanco/db_conexao.php'; 
    
    //inclui transacao para garantir consistencia de dados
    $mySqli->begin_transaction();

    try {
    //inserir dados na tabela PEDIDOS
    $sql = $mySqli->prepare("INSERT INTO tb_pedidos (id_cliente, status_pedido, total_pedido, data_hora_pedido, pagamento_pedido) VALUES (?, 'a fazer', ?, NOW(), ?)");
    $sql->bind_param("ids", $id_cliente, $Total_pedido, $pag_pedido); // i= int, s = string, d=decimal
    $sql->execute();
    
    // Obter o ID do pedido recém-criado
    $id_pedido = $sql->insert_id;

    //inserir cada item na tabela ITENS
    $sql_item = $mySqli->prepare("INSERT INTO tb_itens (id_pedido, id_produto, qtd_item, preco_unita_item, sub_total) VALUES (?,?,?,?,?)");
    
    foreach ($itens as $item) {
        $id_produto = $item[ 'id_produto'];
        $quantidade = $item ['quantidade'];
        $preco_unita_item = $item['preco_produto'];
        $sub_total = $quantidade * $preco_unita_item;

        //inserir no banco
        $sql_item->bind_param("iidid", $id_pedido, $id_produto, $quantidade, $preco_unita_item, $sub_total);
        $sql_item->execute();
        }
        
        // Confirmar a transação
        $mySqli->commit();

        // Retornar sucesso
        echo json_encode(["success" => true]);
    }   
    
    catch (Exception $e) 
    {
    // Em caso de erro, reverter a transação
    $mySqli->rollback();
    echo json_encode(["success" => false, "message" => "Erro ao finalizar pedido: " . $e->getMessage()]);
    }

    // Fechar conexões
    $sql->close();
    $sql_item->close();
    $mySqli->close();



?>
