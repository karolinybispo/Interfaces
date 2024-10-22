<?php
// Incluir conexão com o banco de dados
include '../conexaoBanco/db_conexao.php';

// Consulta para buscar as categorias do banco de dados
$sql_categoria = "SELECT nome_categoria FROM categoria";
$result_categoria = mysqli_query($conn, $sql_categoria);

// Consulta para buscar os produtos do banco de dados
$sql_produto = "SELECT * FROM produto";
$result_produto = mysqli_query($conn, $sql_produto);
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
                <?php 
                // Preencher dinamicamente as categorias na barra de navegação
                while ($categoria = mysqli_fetch_assoc($result_categoria)) {
                    echo '<li>' . htmlspecialchars($categoria['nome_categoria']) . '</li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <main>
        <section class="sugestoes">
            <h2>Sugestões do dia</h2>
            <div class="produto-lista">
                <?php while ($produto = mysqli_fetch_assoc($result_produto)) { ?>
                    <div class="produto">
                    <img src="../CadProdutos/<?php echo htmlspecialchars($produto['foto']); ?>" alt="<?php echo htmlspecialchars($produto['nome_produto']); ?>">

                       <h3><?php echo htmlspecialchars($produto['nome_produto']); ?></h3>
                        <p>R$ <?php echo number_format($produto['preco_produto'], 2, ',', '.'); ?></p>
                        <div class="quantidade">
                            <input type="number" name="quantidade" value="1" min="1" max="<?php echo htmlspecialchars($produto['qtd_estoque']); ?>">
                        </div>
                        <button>Adicionar</button>
                    </div>
                <?php } ?>
            </div>
        </section>
    </main>
</body>
</html>
