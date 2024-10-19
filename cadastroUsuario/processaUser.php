<?php
    
    //verifica erros
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    if($_SERVER["REQUEST_METHOD"] == "POST"){
         include '../conexaoBanco/db_conexao.php'; 
               if ($mySqli->connect_error) { 
                  echo "Erro na conexão: " . $mySqli->connect_error; 
    }
   
       //recebendo valores dos inputs
        $nome = $_POST['nomeInput'];
        $CPF = $_POST['cpfInput'];
        $telefone =$_POST['telefoneInput'];
        $email = $_POST['emailInput'];
        $senha = $_POST ['senhaInput'];

       //preparando insersao de dados
         $sql = $mySqli->prepare("INSERT INTO tb_clientes (nome_cliente, CPF_cliente, telefone_cliente, email_cliente, senha)
                       VALUES (?,?,?,?,?)");
         $sql->bind_param("sssss", $nome, $CPF, $telefone, $email, $senha);
        
         try {
            // tenta executar o comando SQL
            if ( $sql ->execute()){
               //envia o cliente ao login apos o cadastro executado
               header("Location: ../LoginUsuario/loginUsuario.html");
            exit(); // para a execução do script PHP após o redirecionamento
            }
          } //verifica se nome ou e-mail sao unicos no banco
            catch (mysqli_sql_exception $e) {
               if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                  if (strpos($e->getMessage(), 'email_cliente') !== false) {
                  echo "Erro: O email já está cadastrado!";
                } elseif (strpos($e->getMessage(), 'nome') !== false) {
                    echo "Erro: O nome já está cadastrado!";
                } else {
                    echo "Erro ao cadastrar: " . $e->getMessage();
                }
            }
        }
        
        $sql->close();
        $mySqli->close();      
      }  
   ?>

























