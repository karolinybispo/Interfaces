# Explicando do back da tela de pedidos da empresa
- Para exibir dinamicamente na tela da empresa os pedidos, depois de serem feitos pelo user, o PHP devera ser integrado com um banco de dados (MySQL) e usar AJAX (com axios) para atualizar os pedidos em tempo real sem recarregar a pagina.

## Passo a passo
- 1- criar tela no BD para armazenar os pedidos: 
  ``` "CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_pedido INT,
    item VARCHAR(255),
    status ENUM('afazer', 'fazendo', 'feito') DEFAULT 'afazer',
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );"

- 2- Script PHP para ADC os pedidos: um arq PHP salva o pedido feito pelo user no BD
            
        <?php
        // Conecte-se ao banco de dados
        $conn = new mysqli('localhost', 'username', 'password', 'nome_do_banco');

        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

        // Receba os dados do pedido (use métodos de segurança como prepared statements para evitar SQL Injection)
        $numero_pedido = $_POST['numero_pedido'];
        $item = $_POST['item'];
        $status = 'afazer'; // Status inicial

        // Insira o pedido no banco
        $sql = "INSERT INTO pedidos (numero_pedido, item, status) VALUES ('$numero_pedido', '$item', '$status')";
        $conn->query($sql);

        $conn->close();
        ?>"

- 3- Script PHP para obter pedidos: arq php que busca pedidos do banco e retorna-os em formato JSON
      
        <?php
        header('Content-Type: application/json');
        $conn = new mysqli('localhost', 'username', 'password', 'nome_do_banco');

        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

        // Seleciona os pedidos
        $result = $conn->query("SELECT * FROM pedidos ORDER BY data_pedido DESC");

        $pedidos = [];
        while ($row = $result->fetch_assoc()) {
            $pedidos[] = $row;
        }

        echo json_encode($pedidos);

        $conn->close();
        ?>

- 4- Script JS para atualizacao dinamica: sera usado Vue e axios
        links: https://unpkg.com/vue@3/dist/vue.global.js"
                "https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js
  
            const app = Vue.createApp({
            data() {
            return {
                pedidos: {
                    'A Fazer': [],
                    'Fazendo': [],
                    'Feito': []
                }
            };
        },
        mounted() {
            this.fetchPedidos();
            setInterval(this.fetchPedidos, 10000); // Atualiza a cada 10 segundos
        },
        methods: {
            fetchPedidos() {
                axios.get('obter_pedidos.php') // Aqui você faz o GET para o seu script PHP
                    .then(response => {
                        // Atualiza o objeto 'pedidos' com os dados recebidos do PHP
                        this.organizarPedidos(response.data);
                    })
                    .catch(error => {
                        console.error("Erro ao buscar pedidos:", error);
                    });
            },
            organizarPedidos(pedidos) {
                // Limpa os pedidos
                this.pedidos = {
                    'A Fazer': [],
                    'Fazendo': [],
                    'Feito': []
                };

                // Organiza os pedidos nas categorias corretas
                pedidos.forEach(pedido => {
                    if (pedido.status === 'afazer') {
                        this.pedidos['A Fazer'].push(pedido);
                    } else if (pedido.status === 'fazendo') {
                        this.pedidos['Fazendo'].push(pedido);
                    } else if (pedido.status === 'feito') {
                        this.pedidos['Feito'].push(pedido);
                    }
                });
                  }
                  }
                });

                app.mount('#app');


- HTML: ele devera estar nessa estrutura
    
    ```<div id="app">
        <div class="row">
            <div class="col-md-4">
                <h2>A Fazer</h2>
                <div v-for="pedido in pedidosA">
                    <div class="status" :class="pedido.status">
                        <p><strong>N do pedido: {{ pedido.numero_pedido }}</strong></p>
                        <p>{{ pedido.item }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h2>Fazendo</h2>
                <div v-for="pedido in pedidosB">
                    <div class="status" :class="pedido.status">
                        <p><strong>N do pedido: {{ pedido.numero_pedido }}</strong></p>
                        <p>{{ pedido.item }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h2>Feito</h2>
                <div v-for="pedido in pedidosC">
                    <div class="status" :class="pedido.status">
                        <p><strong>N do pedido: {{ pedido.numero_pedido }}</strong></p>
                        <p>{{pedido.item}}</p>
                    </div>
                </div>
            </div>
        </div>
    <div>