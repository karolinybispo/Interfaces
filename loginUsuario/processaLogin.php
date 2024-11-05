<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include '../conexaoBanco/db_conexao.php'; //arq que faz conexao com BD
        // if($conn->connect_error){
        // echo "Erro na conexão: " . $conn->connect_error; 
        // }

        $nome = $_POST['nomeInput'];
        $senha = $_POST['senhaInput'];

        //inserindo um novo cliente
        $sql = $conn->prepare("SELECT id_cliente FROM cliente WHERE nome_cliente = ? AND senha_cliente = ?");
        $sql -> bind_param("ss", $nome, $senha);
        $sql->execute();
        $sql->store_result();

        if($sql->num_rows > 0) {
            // Obtém o ID do cliente
            $sql->bind_result($id_cliente);
            $sql->fetch();

            //armazenando o id no localStorege e depois redirecionando o user
           echo " <script>
                localStorage.setItem('id_cliente', '$id_cliente');
                 window.location.href = '../cardapio/cardapio.php';
                 </script>";
            
        
        }
        else{
            $mensagem = "<p style='color: red;'> nome ou senha invalido!</p>";
        }

        include 'loginUsuario.php';
        //encerra consulta e conexao
        $sql->close();
        $conn->close();

}
?>