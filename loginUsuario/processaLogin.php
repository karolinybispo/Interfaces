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
        $sql->execute();
        $sql->store_result();

        if($sql->num_rows > 0) { //se o numero de linhas retornadas for maior que 0, o nome e senha correspondem ao que esta registrado no banco.
            header("Location: ../cardapio/cardapio.html");
            exit();
        }
        else{
            echo "nome ou senha nao cadastrados";
        }
        //encerra consulta e conexao
        $sql->close();
        $mySqli->close();

}
?>