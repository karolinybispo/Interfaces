<?php

// Verifica erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../conexaoBanco/db_conexao.php'; 
    if ($conn->connect_error) { 
        echo "Erro na conexão: " . $conn->connect_error; 
    }

    // Recebendo valores dos inputs
    $nome = $_POST['nomeInput'];
    $CPF = $_POST['cpfInput'];
    $telefone = $_POST['telefoneInput'];
    $email = $_POST['emailInput'];
    $senha = $_POST['senhaInput'];

    // Verifica se o CPF já existe no banco
    $sqlVerificaCpf = $conn->prepare("SELECT cpf_cliente FROM cliente WHERE cpf_cliente = ?");
    $sqlVerificaCpf->bind_param("s", $CPF);
    $sqlVerificaCpf->execute();
    $resultadoCpf = $sqlVerificaCpf->get_result();

    if ($resultadoCpf->num_rows > 0) {
        echo "Erro: O CPF já está cadastrado!";
    } else {
        // Preparando inserção de dados
        $sql = $conn->prepare("INSERT INTO cliente (nome_cliente, cpf_cliente, telefone_cliente, email_cliente, senha_cliente)
                               VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param("sssss", $nome, $CPF, $telefone, $email, $senha);

        try {
            $sql->execute(); // Tenta executar o comando SQL
            // Redireciona para a página de login após o cadastro bem-sucedido
            header("Location: ../loginUsuario/loginUsuario.php");
            exit();
        } catch (mysqli_sql_exception $e) {
            // Verifica se a mensagem de erro é relacionada a entradas duplicadas
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                if (strpos($e->getMessage(), 'email_cliente') !== false) {
                    echo "Erro: O email já está cadastrado!";
                } elseif (strpos($e->getMessage(), 'nome') !== false) {
                    echo "Erro: O nome já está cadastrado!";
                } else {
                    echo "Erro ao cadastrar: " . $e->getMessage();
                }
            } else {
                // Tratamento para outras exceções, caso necessário
                echo "Erro ao executar a consulta: " . $e->getMessage();
            }
        }

        $sql->close();
    }

    $sqlVerificaCpf->close();
    $conn->close();      
}
?>
