<?php
require 'enviar_email.php';

$emailCliente = 'cantinauninga@gmail.com'; // Substitua por um e-mail válido
$voucherCodigo = strtoupper(bin2hex(random_bytes(4))); // Exemplo: A1B2C3D4

echo enviarVoucher($emailCliente, $voucherCodigo);
