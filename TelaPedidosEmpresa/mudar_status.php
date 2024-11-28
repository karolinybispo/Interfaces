<?php
include '../conexaoBanco/db_conexao.php';
require '../enviar_email.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_pedido']) && isset($_POST['status'])) {
    $id_pedido = intval($_POST['id_pedido']);
    $novo_status = $_POST['status'];

    $status_permitidos = ['a fazer', 'fazendo', 'feito'];
    if (in_array(strtolower($novo_status), $status_permitidos)) {
        $sql = "UPDATE pedido SET status_pedido = '$novo_status' WHERE id_pedido = $id_pedido";
        if (mysqli_query($conn, $sql)) {
            echo "Status atualizado com sucesso!";
        } 

         // Se o status for "feito", enviar o voucher por e-mail
            if ($novo_status === 'feito') {
                // Busca o e-mail do cliente e os detalhes do pedido
                $sqlCliente = "
                    SELECT c.email_cliente, c.nome_cliente, p.valor_total 
                    FROM pedido p
                    JOIN cliente c ON p.id_cliente = c.id_cliente
                    WHERE p.id_pedido = $id_pedido
                ";
                $resultCliente = mysqli_query($conn, $sqlCliente);
                if ($resultCliente && mysqli_num_rows($resultCliente) > 0) {
                    $dadosCliente = mysqli_fetch_assoc($resultCliente);
                    $emailCliente = $dadosCliente['email_cliente'];
                    $nomeCliente = $dadosCliente['nome_cliente'];
                    $valorTotal = number_format($dadosCliente['valor_total'], 2, ',', '.');

                    // Gera o código do voucher
                    $voucherCodigo = strtoupper(bin2hex(random_bytes(4))); // Exemplo: A1B2C3D4

                    // Salva o código do voucher no banco de dados
                    $sqlVoucher = "UPDATE pedido SET voucher = '$voucherCodigo' WHERE id_pedido = $id_pedido";
                    mysqli_query($conn, $sqlVoucher);

                    // Envia o e-mail com o voucher
                    $mensagem = enviarVoucher($emailCliente, $voucherCodigo);

                    // Retorna mensagem de sucesso ou erro no envio do e-mail
                    echo " - " . $mensagem;
                }
            }

    
        else {
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


