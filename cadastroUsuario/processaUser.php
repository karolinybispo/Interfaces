<?php

//verifica erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   include '../conexaoBanco/db_conexao.php';
   if ($conn->connect_error) {
      echo "Erro na conexão: " . $conn->connect_error;
   }

   //recebendo valores dos inputs
   $nome = $_POST['nomeInput'];
   $CPF = $_POST['cpfInput'];
   $telefone = $_POST['telefoneInput'];
   $email = $_POST['emailInput'];
   $senha = $_POST['senhaInput'];

   //preparando insersao de dados
   $sql = $conn->prepare("INSERT INTO cliente (nome_cliente, cpf_cliente, telefone_cliente, email_cliente, senha_cliente) VALUES (?,?,?,?,?)");
   $sql->bind_param("sssss", $nome, $CPF, $telefone, $email, $senha);

   try {
      // tenta executar o comando SQL
      if ($sql->execute()) {
         //envia o cliente ao login apos o cadastro executado
         header("Location: ../LoginUsuario/loginUsuario.html");
         exit(); // para a execução do script PHP após o redirecionamento
      }
   } //verifica se nome ou e-mail sao unicos no banco
   catch (mysqli_sql_exception $e) {
      if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
         if (strpos($e->getMessage(), 'email_cliente') !== false) {
            echo "Erro: O email já está cadastrado!";
         } elseif (strpos($e->getMessage(), 'nome_cliente') !== false) { // mudando o valor de nome para nome_cliente para ficar com o mesmo nome da coluna do banco
            $mensagemErro = "Nome ja cadastrado";
         } else {
            echo "Erro ao cadastrar: " . $e->getMessage();
         }
      }
   }

   $sql->close();
   $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
   <!--suportar uma ampla gama de caracteres -->
   <meta charset="UTF-8">
   <!--garante responsividade para dispositivos moveis-->
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- titulo da pagina na aba do navegador-->
   <title>Cadastro de novo usurario</title>
   <!-- vinculo o css externo utilizado para estilizar o html-->
   <link rel="stylesheet" href="cadastroUsuario.css">

   <!-- inicia o corpo do conteudo visivel-->

<body>
   <!-- inicia um elemento div com a classe form-container usado para agrupar e estilizar-->
   <div class="form-container">
      <!-- titulo do formulario-->
      <h2>Cadastro</h2>

      <!-- inicia o formulario com metodo e action para indicar para onde sera enviado-->
      <form action="./processaUser.php" method="POST">

         <!-- cria um elemento div com a classe campo para personalizar os campos-->
         <div class="campo">
            <!--cria um campo input com name e placeholder mostra a palavra que ficara a mostra-->
            <!-- required torna o preenchimento obrigatorio-->
            <input type="text" name="nomeInput" placeholder="nome" required>
         </div>
         <div class="campo">
            <input type="text" name="cpfInput" placeholder="CPF" required>
         </div>
         <div class="campo">
            <input type="text" name="telefoneInput" placeholder="telefone" required>
         </div>
         <div class="campo">
            <input type="email" name="emailInput" placeholder="e-mail" required>
         </div>
         <div class="campo">
            <input type="password" name="senhaInput" placeholder="senha" required>
         </div>
         <div class="campo">
            <!--botão do tipo submit para enviar o formulario-->
            <button type="submit">finalizar</button>
            <?php
            if ($mensagemErro) {
               echo "<p style='color: red;'>$mensagemErro</p>";
            }
            ?>
         </div>
      </form>
   </div>
</body>

</html>