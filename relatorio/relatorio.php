<?php
include '../conexaoBanco/db_conexao.php';

// Função para formatar valores monetários
function formatarMoeda($valor) {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

// Função para buscar o Relatório de Vendas Diárias
function getRelatorioVendasDiarias($data) {
    global $conn;
    $sql = "SELECT COUNT(id_pedido) AS total_pedidos, SUM(total_pedido) AS receita_total 
            FROM pedido 
            WHERE DATE(data_pedido) = '$data'";
    $result = mysqli_query($conn, $sql);
    $relatorio = mysqli_fetch_assoc($result);
    
    // Buscar os produtos mais vendidos no dia
    $sql_produtos = "SELECT p.nome_produto, SUM(i.qtd) AS quantidade_vendida 
                     FROM itens i 
                     JOIN produto p ON i.id_produtos = p.id_produto 
                     JOIN pedido pd ON i.id_pedido = pd.id_pedido
                     WHERE DATE(pd.data_pedido) = '$data'
                     GROUP BY p.nome_produto 
                     ORDER BY quantidade_vendida DESC 
                     LIMIT 5";
    $result_produtos = mysqli_query($conn, $sql_produtos);
    $relatorio['produtos_mais_vendidos'] = mysqli_fetch_all($result_produtos, MYSQLI_ASSOC);

    return $relatorio;
}

// Função para buscar o Relatório de Produtos Mais Vendidos em um período
function getRelatorioProdutosMaisVendidos($data_inicio, $data_fim) {
    global $conn;
    $sql = "SELECT p.nome_produto, SUM(i.qtd) AS quantidade_vendida, SUM(i.sub_total) AS receita_gerada
            FROM itens i 
            JOIN produto p ON i.id_produtos = p.id_produto 
            JOIN pedido pd ON i.id_pedido = pd.id_pedido
            WHERE DATE(pd.data_pedido) BETWEEN '$data_inicio' AND '$data_fim'
            GROUP BY p.nome_produto 
            ORDER BY quantidade_vendida DESC 
            LIMIT 10";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Função para buscar o Relatório Financeiro Mensal
function getRelatorioFinanceiroMensal($mes, $ano) {
    global $conn;
    $sql = "SELECT SUM(total_pedido) AS receita_total 
            FROM pedido 
            WHERE MONTH(data_pedido) = $mes AND YEAR(data_pedido) = $ano";
    $result = mysqli_query($conn, $sql);
    $dados = mysqli_fetch_assoc($result);

    $despesas_totais = 1000.00; // Exemplo de valor fixo de despesas
    $dados['despesas_totais'] = $despesas_totais;
    $dados['lucro_liquido'] = $dados['receita_total'] - $despesas_totais;

    return $dados;
}

// Verificar se há uma data ou intervalo para o relatório de vendas diárias
$data_diaria = isset($_POST['data_diaria']) ? $_POST['data_diaria'] : date('Y-m-d');
$relatorio_vendas_diarias = getRelatorioVendasDiarias($data_diaria);

// Verificar se há um intervalo de datas para o relatório de produtos mais vendidos
$data_inicio = isset($_POST['data_inicio']) ? $_POST['data_inicio'] : date('Y-m-01');
$data_fim = isset($_POST['data_fim']) ? $_POST['data_fim'] : date('Y-m-t');
$relatorio_produtos = getRelatorioProdutosMaisVendidos($data_inicio, $data_fim);

// Verificar se há um mês e ano para o relatório financeiro mensal
$mes = isset($_POST['mes']) ? $_POST['mes'] : date('m');
$ano = isset($_POST['ano']) ? $_POST['ano'] : date('Y');
$relatorio_financeiro = getRelatorioFinanceiroMensal($mes, $ano);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios da Cantina</title>
    <link rel="stylesheet" href="relatorio.css">
</head>
<body>
        <!-- Barra de Navegação -->
    <nav class="navbar">
        <ul>
            <li><a href="../TelaPedidosEmpresa/Pedidos.php">Pedidos</a></li>
            <li><a href="../CadProdutos/cadastroProdutos.php">Cadastro de Produto</a></li>
            <li><a href="../cadastroCategoria/cadCategoria.php">Cadastro de Categoria</a></li>
           
        </ul>
    </nav>

    <h1>Relatórios da Cantina</h1>

    <section>
        <h2>Relatório de Vendas Diárias</h2>
        <form method="POST">
            <label for="data_diaria">Data:</label>
            <input type="date" name="data_diaria" value="<?php echo $data_diaria; ?>">
            <button type="submit">Buscar</button>
        </form>
        <p>Total de Pedidos: <?php echo $relatorio_vendas_diarias['total_pedidos']; ?></p>
        <p>Receita Total: <?php echo formatarMoeda($relatorio_vendas_diarias['receita_total']); ?></p>
        <h3>Produtos Mais Vendidos do Dia</h3>
        <ul>
            <?php foreach ($relatorio_vendas_diarias['produtos_mais_vendidos'] as $produto): ?>
                <li><?php echo $produto['nome_produto']; ?> - Quantidade Vendida: <?php echo $produto['quantidade_vendida']; ?></li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section>
        <h2>Relatório de Produtos Mais Vendidos</h2>
        <form method="POST">
            <label for="data_inicio">Data Início:</label>
            <input type="date" name="data_inicio" value="<?php echo $data_inicio; ?>">
            <label for="data_fim">Data Fim:</label>
            <input type="date" name="data_fim" value="<?php echo $data_fim; ?>">
            <button type="submit">Buscar</button>
        </form>
        <ul>
            <?php foreach ($relatorio_produtos as $produto): ?>
                <li><?php echo $produto['nome_produto']; ?> - Quantidade Vendida: <?php echo $produto['quantidade_vendida']; ?> - Receita Gerada: <?php echo formatarMoeda($produto['receita_gerada']); ?></li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section>
        <h2>Relatório Financeiro Mensal</h2>
        <form method="POST">
            <label for="mes">Mês:</label>
            <input type="number" name="mes" min="1" max="12" value="<?php echo $mes; ?>">
            <label for="ano">Ano:</label>
            <input type="number" name="ano" min="2000" max="2100" value="<?php echo $ano; ?>">
            <button type="submit">Buscar</button>
        </form>
        <p>Receita Total: <?php echo formatarMoeda($relatorio_financeiro['receita_total']); ?></p>
        <p>Despesas Totais: <?php echo formatarMoeda($relatorio_financeiro['despesas_totais']); ?></p>
        <p>Lucro Líquido: <?php echo formatarMoeda($relatorio_financeiro['lucro_liquido']); ?></p>
    </section>

</body>
</html>
