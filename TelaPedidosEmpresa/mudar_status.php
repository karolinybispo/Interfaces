<?php
include '../conexaoBanco/db_conexao.php';
require '../enviar_email.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pedido'], $_POST['status'])) {
    $id_pedido = intval($_POST['id_pedido']);
    $novo_status = $_POST['status'];
    $status_permitidos = ['a fazer', 'fazendo', 'feito'];

    if (in_array($novo_status, $status_permitidos)) {
        $sql = "UPDATE pedido SET status_pedido = ? WHERE id_pedido = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $novo_status, $id_pedido);

        if ($stmt->execute()) {
            if ($novo_status === 'feito') {
                // Busca os dados do cliente e do pedido
                $query = "
                    SELECT c.email_cliente, c.nome_cliente
                    FROM pedido p
                    JOIN cliente c ON p.id_cliente = c.id_cliente
                    WHERE p.id_pedido = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $id_pedido);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $cliente = $result->fetch_assoc();
                    $email = $cliente['email_cliente'];
                    $nome = $cliente['nome_cliente'];

                    // Gera e salva o voucher
                    $voucher = strtoupper(bin2hex(random_bytes(4)));
                    $sqlVoucher = "UPDATE pedido SET voucher = ? WHERE id_pedido = ?";
                    $stmt = $conn->prepare($sqlVoucher);
                    $stmt->bind_param("si", $voucher, $id_pedido);
                    if ($stmt->execute()) {
                        // Envia o e-mail com o voucher
                        $mensagem = enviarVoucher($email, $voucher);
                        echo json_encode([
                            "status" => "success",
                            "message" => "Status atualizado e e-mail enviado!",
                            "voucher" => $voucher
                        ]);
                    } else {
                        echo json_encode([
                            "status" => "error",
                            "message" => "Erro ao salvar voucher."
                        ]);
                    }
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "Cliente não encontrado."
                    ]);
                }
            } else {
                echo json_encode([
                    "status" => "success",
                    "message" => "Status atualizado com sucesso!"
                ]);
            }
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Erro ao atualizar status: " . $conn->error
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Status inválido."
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Dados incompletos."
    ]);
}
$conn->close();
?>
