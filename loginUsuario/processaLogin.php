<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include '../conexaoBanco/db_conexao.php'; //arq que faz conexao com BD
        if($mySqli->connect_error){
            echo "Erro na conexão: " . $mySqli->connect_error; 
        }

        $nome = $_POST['nomeInput'];
        $senha = $_POST['senhaInput'];

        $sql = $mySqli->prepare("SELECT id_cliente FROM tb_clientes WHERE nome_cliente = ? AND senha = ?");
        $sql -> bind_param("ss", $nome, $senha);
        $sql->execute(); //excuta a consulta de incluir os valores de $nome e $senha dentro dos ?
        $sql->store_result(); //guarda o resultado da consulta feita

        if($sql->num_rows > 0) { //se o numero de linhas retornadas for maior que 0, o nome e senha inseridos correspondem ao que esta registrado no banco.
            
            $sql->bind_result($id_cliente); //prepara a variavel $id_cliente para receber o valor da coluna id_cliente do BD
            $sql->fetch();//executa a extracao do valor da consulta e armazena o resultado na variavel $id_cliente

            //armazenando o id no localStorege (isso permite o id ser recuperado depois) e depois redirecionando o user
           echo " <script>
                        localStorage.setItem('id_cliente', '$id_cliente');
                        window.location.href = '../cardapio/cardapio.html';
                 </script>";
        }
        else{
            echo "nome ou senha nao cadastrados";
        }

        //encerra consulta e conexao
        $sql->close();
        $mySqli->close();

}
?>