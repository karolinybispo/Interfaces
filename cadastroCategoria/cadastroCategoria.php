<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cadastroCategoria.css">
    <title>Cadastro de categoria</title>
</head>

<body>
    <!-- NAV-BAR -->
    <div class="navbar">
        <button class="navbar-toggler" id="navbar-toggler">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
        <div class="navbar-collapse" id="navbar-collapse">
            <ul class="navbar-nav">
                <li><a href="../CadProdutos/cadastroProdutos.php">Cadastro de novos produtos</a></li>
                <li><a href="relatorio.html">Relatorios</a></li>
                <li><a href="../TelaPedidosEmpresa/Pedidos.php">Pedidos online</a></li>

            </ul>
        </div>
    </div>
    <script src="scriptCategoria.js"></script>

    <!--CADASTRO DE CATEGORIA-->
    <div class="category-registration-container">
        <div class="category-registration-box">
            <h2>Cadastro de Categorias</h2>
            <div class="form">
                <form action="salvarCategoria.php" method="POST">
                    <div class="campo">
                        <label for="categoria">Categoria</label>
                        <input type="text" id="categoria" name="categoria" placeholder="Nome da categoria" required>
                    </div>
                
                    <div class="campo">
                        <button type="submit" class="btn-adicionar">adicionar</button>
                    </div>
            </div>

            </form>
        </div>
    </div>
</body>

</html>