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
        //inseri dados na tabela pedidos
        $sql = $mySqli->prepare("INSERT INTO tb_pedidos (id_cliente, status_pedido, total_pedido, data_hora_pedido, pagamento_pedido) VALUES (?, 'a fazer', 0, NOW(), ?)");
        $sql->bind_param("is", $id_cliente, $pag_pedido); // i= int, s = string. as colunas id_cliente e pagamento_pedido vao receber seus valores daqui.
        $sql->execute();

        // Obter o id_pedido gerado
        $id_pedido = $conn->insert_id;

        //inserir cada item na tabela tb_itens
        


    }




?>