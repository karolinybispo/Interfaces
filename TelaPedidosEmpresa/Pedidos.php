<?php
include '../conexaoBanco/db_conexao.php';
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
            <li><a href="../cadastroCategoria/cadastrocategoria.php">Cadastro de Categoria</a></li>
            <li><a href="../relatorio/relatorio.php">Relatório</a></li>
        </ul>
    </nav>

    <h1>Gerenciamento de Pedidos </h1>
    <div class="kanban-board">
        <div class="kanban-column">
            <h2>A Fazer</h2>
            <div class="kanban-items" id="a-fazer"></div>
        </div>
        <div class="kanban-column">
            <h2>Fazendo</h2>
            <div class="kanban-items" id="fazendo"></div>
        </div>
        <div class="kanban-column">
            <h2>Feito</h2>
            <div class="kanban-items" id="feito"></div>
        </div>
    </div>

    <script>
        function atualizarPedidos() {
            fetch('buscar_pedidos.php')
                .then(response => response.json())
                .then(pedidos => {
                    document.getElementById('a-fazer').innerHTML = '';
                    document.getElementById('fazendo').innerHTML = '';
                    document.getElementById('feito').innerHTML = '';

                    pedidos.forEach(pedido => {
                        let coluna;
                        if (pedido.status === 'A fazer') {
                            coluna = document.getElementById('a-fazer');
                        } else if (pedido.status === 'Fazendo') {
                            coluna = document.getElementById('fazendo');
                        } else if (pedido.status === 'Feito') {
                            coluna = document.getElementById('feito');
                        }

                        if (coluna) {
                            const pedidoDiv = document.createElement('div');
                            pedidoDiv.className = 'kanban-item';
                            pedidoDiv.dataset.id = pedido.id_pedido;

                            pedidoDiv.innerHTML = `
                                <h3>Pedido #${pedido.id_pedido}</h3>
                                <p>Cliente ID: ${pedido.id_cliente}</p>
                                <p>Valor Total: R$ ${Number(pedido.total_pedido).toFixed(2).replace('.', ',')}</p>
                                <ul>
                                    ${pedido.itens.map(item => `
                                        <li><strong>${item.nome_produto}</strong> - Quantidade: ${item.qtd}<br>
                                        Preço Unitário: R$ ${Number(item.preco_unita_item).toFixed(2).replace('.', ',')} - Subtotal: R$ ${Number(item.sub_total).toFixed(2).replace('.', ',')}</li>
                                    `).join('')}
                                </ul>
                                ${pedido.status !== 'Feito' ? `<button onclick="mudarStatus(${pedido.id_pedido}, '${pedido.status === 'A fazer' ? 'Fazendo' : 'Feito'}')">${pedido.status === 'A fazer' ? 'Iniciar' : 'Concluir'}</button>` : ''}
                            `;
                            
                            coluna.appendChild(pedidoDiv);
                        }
                    });
                })
                .catch(error => console.error('Erro ao buscar pedidos:', error));
        }

        function mudarStatus(idPedido, novoStatus) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "mudar_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    atualizarPedidos();
                }
            };
            xhr.send("id_pedido=" + idPedido + "&status=" + novoStatus);
        }

        setInterval(atualizarPedidos, 5000);
        atualizarPedidos();
    </script>
</body>
</html>

