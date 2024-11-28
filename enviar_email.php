<?php
require_once 'src/PHPMailer.php';  // Inclui o PHPMailer
require_once 'src/Exception.php'; // Inclui as exceções do PHPMailer
require_once 'src/SMTP.php';      // Inclui o SMTP do PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarVoucher($emailUsuario, $voucherCodigo) {
    $mail = new PHPMailer(true);

    try {
        // Configuração do servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';             // Servidor SMTP do Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'cantinauninga@gmail.com';     // Seu e-mail do Gmail
        $mail->Password = 'kwsl rmji vbjf jrmr';       // Senha de app do Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuração do e-mail
        $mail->setFrom('cantinauninga@gmail.com', 'Cantina Uningá'); // Remetente
        $mail->addAddress($emailUsuario);                         // Destinatário

        $mail->isHTML(true);                                      // Enviar como HTML
        $mail->Subject = 'Seu voucher de pedido';
        $mail->Body = "
            <h1>Pedido Concluído!</h1>
            <p>Obrigado por seu pedido. Aqui está seu voucher:</p>
            <p><strong>$voucherCodigo</strong></p>
        ";

        $mail->send();
        return "E-mail enviado com sucesso!";
    } catch (Exception $e) {
        return "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
}
