<?php
include '../conexaoBanco/db_conexao.php';

// Consulta para buscar os produtos do banco de dados
$sql = "SELECT * FROM produto";
$result = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio da Cantina</title>
    <style>
        /* Estilize conforme seu gosto, aqui vai um exemplo básico */
        .produto {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            width: 200px;
        }
        .produto img {
            width: 100%;
        }
    </style>
</head>
<body>

<h1>Cardápio da Cantina</h1>

<div id="produtos">
    <?php while ($produto = mysqli_fetch_assoc($result)) { ?>
        <div class="produto">
            <h2><?php echo $produto['nome_produto']; ?></h2>
            <p>Preço: R$ <?php echo $produto['preco_produto']; ?></p>
            <p><?php echo $produto['descricao']; ?></p>
            <form action="adicionarCarrinho.php" method="POST">
                <input type="hidden" name="id_produto" value="<?php echo $produto['id_produto']; ?>">
                <input type="number" name="quantidade" value="1" min="1" max="<?php echo $produto['qtd_estoque']; ?>">
                <button type="submit">Adicionar ao Carrinho</button>
            </form>
        </div>
    <?php } ?>
</div>

</body>
</html>