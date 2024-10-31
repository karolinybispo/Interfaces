<?php
// Incluir conexão com o banco de dados
include '../conexaoBanco/db_conexao.php';

// Consulta para buscar os pedidos do banco de dados
$sql_pedidos = "SELECT * FROM pedido";
$result_pedidos = mysqli_query($conn, $sql_pedidos);

// Testar se a consulta retornou resultados
if (!$result_pedidos) {
    die("Erro na consulta SQL: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Pedidos </title>
    <link rel="stylesheet" href="kanban.css">
</head>
<body>

    <!-- Barra de Navegação -->
    <nav class="navbar">
        <ul>
            <li><a href="../CadProdutos/cadastroProdutos.php">Cadastro de Produto</a></li>
            <li><a href="../cadastroCategoria/cadCategoria.php">Cadastro de Categoria</a></li>
            <li><a href="relatorio.php">Relatório</a></li>
        </ul>
    </nav>

    <h1>Gerenciamento de Pedidos </h1>
    <div class="kanban-board">
        <!-- Coluna "A Fazer" -->
        <div class="kanban-column">
            <h2>A Fazer</h2>
            <div class="kanban-items" id="a-fazer">
                <?php
                mysqli_data_seek($result_pedidos, 0);
                while ($pedido = mysqli_fetch_assoc($result_pedidos)) {
                    if ($pedido['status'] == 'A fazer') {
                        echo '<div class="kanban-item" data-id="' . $pedido['id_pedido'] . '">';
                        echo '<h3>Pedido #' . $pedido['id_pedido'] . '</h3>';
                        echo '<p>Cliente ID: ' . $pedido['id_cliente'] . '</p>';
                        echo '<p>Valor Total: R$ ' . number_format($pedido['total_pedido'], 2, ',', '.') . '</p>';

                        // Consultar itens do pedido
                        $sql_itens = "SELECT i.qtd, i.preco_unita_item, i.sub_total, p.nome_produto 
                                      FROM itens i
                                      JOIN produto p ON i.id_produtos = p.id_produto
                                      WHERE i.id_pedido = " . $pedido['id_pedido'];
                        $result_itens = mysqli_query($conn, $sql_itens);

                        // Exibir itens do pedido com a nova formatação
                        echo '<ul>';
                        while ($item = mysqli_fetch_assoc($result_itens)) {
                            echo '<li><strong>' . $item['nome_produto'] . '</strong> - Quantidade: ' . $item['qtd'] . '<br>';
                            echo 'Preço Unitário: R$ ' . number_format($item['preco_unita_item'], 2, ',', '.') . ' - Subtotal: R$ ' . number_format($item['sub_total'], 2, ',', '.') . '</li>';
                        }
                        echo '</ul>';

                        echo '<button onclick="mudarStatus(' . $pedido['id_pedido'] . ', \'Fazendo\')">Iniciar</button>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>

        <!-- Coluna "Fazendo" -->
        <div class="kanban-column">
            <h2>Fazendo</h2>
            <div class="kanban-items" id="fazendo">
                <?php
                mysqli_data_seek($result_pedidos, 0);
                while ($pedido = mysqli_fetch_assoc($result_pedidos)) {
                    if ($pedido['status'] == 'Fazendo') {
                        echo '<div class="kanban-item" data-id="' . $pedido['id_pedido'] . '">';
                        echo '<h3>Pedido #' . $pedido['id_pedido'] . '</h3>';
                        echo '<p>Cliente ID: ' . $pedido['id_cliente'] . '</p>';
                        echo '<p>Valor Total: R$ ' . number_format($pedido['total_pedido'], 2, ',', '.') . '</p>';

                        // Consultar itens do pedido com a nova formatação
                        $sql_itens = "SELECT i.qtd, i.preco_unita_item, i.sub_total, p.nome_produto 
                                      FROM itens i
                                      JOIN produto p ON i.id_produtos = p.id_produto
                                      WHERE i.id_pedido = " . $pedido['id_pedido'];
                        $result_itens = mysqli_query($conn, $sql_itens);

                        echo '<ul>';
                        while ($item = mysqli_fetch_assoc($result_itens)) {
                            echo '<li><strong>' . $item['nome_produto'] . '</strong> - Quantidade: ' . $item['qtd'] . '<br>';
                            echo 'Preço Unitário: R$ ' . number_format($item['preco_unita_item'], 2, ',', '.') . ' - Subtotal: R$ ' . number_format($item['sub_total'], 2, ',', '.') . '</li>';
                        }
                        echo '</ul>';

                        echo '<button onclick="mudarStatus(' . $pedido['id_pedido'] . ', \'Feito\')">Concluir</button>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>

        <!-- Coluna "Feito" -->
        <div class="kanban-column">
            <h2>Feito</h2>
            <div class="kanban-items" id="feito">
                <?php
                mysqli_data_seek($result_pedidos, 0);
                while ($pedido = mysqli_fetch_assoc($result_pedidos)) {
                    if ($pedido['status'] == 'Feito') {
                        echo '<div class="kanban-item" data-id="' . $pedido['id_pedido'] . '">';
                        echo '<h3>Pedido #' . $pedido['id_pedido'] . '</h3>';
                        echo '<p>Cliente ID: ' . $pedido['id_cliente'] . '</p>';
                        echo '<p>Valor Total: R$ ' . number_format($pedido['total_pedido'], 2, ',', '.') . '</p>';

                        // Consultar itens do pedido com a nova formatação
                        $sql_itens = "SELECT i.qtd, i.preco_unita_item, i.sub_total, p.nome_produto 
                                      FROM itens i
                                      JOIN produto p ON i.id_produtos = p.id_produto
                                      WHERE i.id_pedido = " . $pedido['id_pedido'];
                        $result_itens = mysqli_query($conn, $sql_itens);

                        echo '<ul>';
                        while ($item = mysqli_fetch_assoc($result_itens)) {
                            echo '<li><strong>' . $item['nome_produto'] . '</strong> - Quantidade: ' . $item['qtd'] . '<br>';
                            echo 'Preço Unitário: R$ ' . number_format($item['preco_unita_item'], 2, ',', '.') . ' - Subtotal: R$ ' . number_format($item['sub_total'], 2, ',', '.') . '</li>';
                        }
                        echo '</ul>';

                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        // Função para mudar o status do pedido
        function mudarStatus(idPedido, novoStatus) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "mudar_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    location.reload(); // Recarregar a página para atualizar o status dos pedidos
                }
            };
            xhr.send("id_pedido=" + idPedido + "&status=" + novoStatus);
        }
    </script>
</body>
</html>
