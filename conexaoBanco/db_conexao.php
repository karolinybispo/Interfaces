<?php
$nomeServer = "localhost";
$userServer = "root";
$senhaServer = "";
$nomeBanco = "cantina"; // Substitua pelo nome do seu banco de dados

// Criando a conexão com o banco de dados
$mySqli = new mysqli($nomeServer, $userServer, $senhaServer, $nomeBanco);

?>
