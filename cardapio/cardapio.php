<?php
// Incluir conexão com o banco de dados
include '../conexaoBanco/db_conexao.php';

// Consulta para buscar os produtos do banco de dados
$sql = "SELECT * FROM produto"; // Certifique-se de que o nome da tabela e dos campos estão corretos
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio</title>
    <link rel="stylesheet" href="cardapio.css">
</head>
<body>
    <header>
        <div class="header-bar">
            <input type="text" placeholder="pesquise">
            <div class="logo">
                <img src="logo_uninga.png" alt="Uninga">
            </div>
        </div>
        <nav>
            <ul>
                <li>Bebidas</li>
                <li>Salgados</li>
                <li>Sobremesas</li>
                <li>Prato feito</li>
                <li>Lanches</li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="sugestoes">
            <h2>Sugestões do dia</h2>
            <div class="produto-lista">
                <?php while ($produto = mysqli_fetch_assoc($result)) { ?>
                    <div class="produto">
                        <img src="<?php echo $produto['foto']; ?>" alt="<?php echo $produto['nome_produto']; ?>">
                        <h3><?php echo $produto['nome_produto']; ?></h3>
                        <p>R$ <?php echo number_format($produto['preco_produto'], 2, ',', '.'); ?></p>
                        <div class="quantidade">
                            <input type="number" name="quantidade" value="1" min="1" max="<?php echo $produto['qtd_estoque']; ?>">
                        </div>
                        <button>Adicionar</button>
                    </div>
                <?php } ?>
            </div>
        </section>
    </main>
</body>
</html>
