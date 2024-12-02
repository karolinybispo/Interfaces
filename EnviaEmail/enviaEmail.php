<?php
// Inclua o PHPMailer
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Dados recebidos (ex.: via POST)
$clienteEmail = $_POST['email']; // E-mail do cliente
$numeroPedido = $_POST['numeroPedido']; // Número do pedido

$mail = new PHPMailer(true);

try {
    // Configuração do servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com'; // Servidor SMTP da Microsoft
    $mail->SMTPAuth = true;
    $mail->Username = 'seuhotmail@hotmail.com'; // Seu e-mail Hotmail
    $mail->Password = 'suasenha'; // Sua senha ou senha de aplicativo
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Configuração do e-mail
    $mail->setFrom('seuhotmail@hotmail.com', 'Sua Loja');
    $mail->addAddress($clienteEmail); // E-mail do cliente
    $mail->Subject = 'Voucher do Pedido #' . $numeroPedido;
    $mail->Body = "Olá! Seu pedido de número {$numeroPedido} está pronto para retirada.\n\nObrigado por comprar conosco!";
    $mail->AltBody = "Olá! Seu pedido de número {$numeroPedido} está pronto para retirada. Obrigado por comprar conosco!";

    // Enviar o e-mail
    $mail->send();
    echo 'E-mail enviado com sucesso!';
} catch (Exception $e) {
    echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
}
