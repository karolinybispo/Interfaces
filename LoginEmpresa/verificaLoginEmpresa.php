<?php

//PARA MOSTRAR ERROS
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include '../conexaoBanco/db_conexao.php'; //arquivo que faz conexao com BD
        // if($conn->connect_error){
        // echo "Erro na conexão: " . $conn->connect_error; 
        // }
    
        //recebe dados do formulario 
        $cnpj = $_POST['cnpj'];
        $senha = $_POST['senha'];

        //consulta para verificar se o CNPJ e SENHA correspondem a um registro existente.
        $sql = $conn->prepare("SELECT * FROM empresa WHERE cnpj = ? AND senha = ?");
        $sql->bind_param("ss", $cnpj, $senha); // as variaveis $cnpj e $senha sao associadas aos '?' na linha 19 e serao preenchidos com esses valores.
        $sql->execute(); // executa consulta SQL.
        $result = $sql->get_result(); // obtem o resultado da consulta.

        if($result->num_rows > 0) {  //verifica se encontrou o registro. Analisa se o numero de linhas no resultado eh maior que zero (ou seja, se existe um registro correspondente).
            //esse script JS faz um alert com uma mensagem e encaminha a empresa para tela de pedidos.
            echo "<script>
                alert('Login bem-sucedido!');
                window.location.href = '../TelaPedidosEmpresa/Pedidos.php'; 
              </script>";
        } else {
            echo "<script>
                alert('CNPJ ou senha não cadastrados.');
                </script>";
        }
        //encerra consulta e conexao
        $sql->close();
        $conn->close();
    }
?>