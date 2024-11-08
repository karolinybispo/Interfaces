<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Novos Produtos</title>
    <link rel="stylesheet" href="cadastroProdutos.css">
    <script>
        // Função para buscar as categorias via AJAX
        function buscarCategorias() {
            // Faz a requisição para o arquivo PHP
            fetch('buscarCategorias.php')
                .then(response => response.json()) // Converte a resposta para JSON
                .then(categorias => {
                    let selectCategoria = document.getElementById("id_categoria");
                    
                    // Limpa o select antes de adicionar as categorias
                    selectCategoria.innerHTML = '';
                    
                    // Itera sobre as categorias e as adiciona ao select
                    categorias.forEach(categoria => {
                        let option = document.createElement("option");
                        option.value = categoria.id_categoria;
                        option.text = categoria.nome_categoria;
                        selectCategoria.add(option);
                    });
                })
                .catch(error => {
                    console.error('Erro ao buscar as categorias:', error);
                });
        }

        // Chama a função assim que a página carrega
        window.onload = function() {
            buscarCategorias();
        };
    </script>
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
                <li><a href="../cadastroCategoria/cadastroCategoria.php">Cadastro de categoria</a></li>
                <li><a href="../relatorio/relatorio.php">Relatorios</a></li>
                <li><a href="../TelaPedidosEmpresa/Pedidos.php">Pedidos online</a></li>
              
            </ul>
        </div>
    </div>
    
<div class="container">
    <div class="product-registration-container">
        <div class="product-registration-box">
        
            <h2>Cadastro de novo produto</h2>
            <form action="salvarProduto.php" method="POST" enctype="multipart/form-data">
                <div class="campo">
                <label for="id_categoria">Categoria:</label>
                <select id="id_categoria" name="id_categoria" required>
                    <!-- As opções serão preenchidas dinamicamente -->
                </select><br><br>
            </div>
                <div class="campo">
                    <label for="produto">Produto</label>
                    <input type="text" id="produto" name="nome_produto" placeholder="nome produto" required>
                </div>
                <div class="campo">
                    <label for="descricao">Descrição do produto</label>
                    <textarea id="descricao" name="descricao" placeholder="descrição do novo produto" required></textarea> <!--tag q permite varias linhas de texto-->
                </div>
                <div class="campo">
                    <label for="preco_produto">Preço:</label>
                    <input type="number" step="0.01" id="preco_produto" name="preco_produto" required><br><br>
                </div>
                <div class="campo">
                     <label for="qtd_estoque">Quantidade em Estoque:</label>
                     <input type="number" id="qtd_estoque" name="qtd_estoque" required><br><br>
                </div>
                <div>
                    <label for="foto"> Escolha a foto do produto:</label>
                     <input type="file" id="foto" name="foto" accept="image/*" required>
                </div>
                <br>
                <div class="campo">
                    <button type="submit" class="btn-adicionar">adicionar</button>
                    <?php if (isset($mensagem)) echo $mensagem; ?>
                </div>
            </form>
        </div>
    </div>
</div>
    <script src="./scriptProdutos.js"></script>
</body>
</html>

