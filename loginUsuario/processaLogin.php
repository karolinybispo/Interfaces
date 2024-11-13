<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mensagemErro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../conexaoBanco/db_conexao.php';
    if ($conn->connect_error) {
        echo "Erro na conexão: " . $conn->connect_error;
    }

    $nome = $_POST['nomeInput'];
    $senha = $_POST['senhaInput'];

    $sql = $conn->prepare("SELECT id_cliente FROM cliente WHERE nome_cliente = ? AND senha_cliente = ?");
    $sql->bind_param("ss", $nome, $senha);
    $sql->execute();
    $sql->store_result();

    if ($sql->num_rows > 0) {
        $sql->bind_result($id_cliente);
        $sql->fetch();

        echo "<script>
                localStorage.setItem('id_cliente', '$id_cliente');
                window.location.href = '../cardapio/cardapio.html';
              </script>";
    } else {
        $mensagemErro = "Nome ou senha não cadastrados";
    }

    $sql->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="loginUsuario.css">
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>
            <form action="./processaLogin.php" method="POST">
                <div class="campo">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nomeInput" required>
                </div>
                <div class="campo">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senhaInput" required>
                </div>

                <div class="campo">
                    <button type="submit" class="btn-login">Entrar</button> <!--ao entrar vai para o aqr processaLogin.php definido no action-->
                </div>

                <?php
                if ($mensagemErro) {
                    echo "<p style='color: red;'>$mensagemErro</p>";
                }
                ?>
                <div class="campo">
                    <button type="button" class="btn-cadastrar" onclick="window.location.href='../cadastroUsuario/cadastroUsuario.html'">Cadastrar</button>
                </div>

                <div class="link">
                    <a href="../recuperarSenha/recuperarSenha.html">esqueci a senha</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>