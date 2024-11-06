# Sistema de voucher para cantina

# Branchs
- main: ficam os arquivos para produção.
- release: cria, modifica, altera os arquivos.

# Planejamento e inicio do Frontend
## Ferramentas e Tecnologias utilizadas:
Frontend: HTML, CSS, JavaScript.
Backend: PHP.
Banco de Dados: MySQL.
Versionamento: Git e GitHub para controle de versão.
Pagamentos: Integração com Pix.

## Desenvolvimento do Frontend
Criar telas: 
- Cadastro do cliente: campos: nome| cpf | telefone | e-mail | senha
Validar CPF
Validar Email
Requisitos para criar senha

- Login cliente: Campos: CPF | Senha
Recuperar senha

- Recuperação de senha: Campos: e-mail 
Implementar recuperação de senha

- Cardapio: Campos: imagem do produto | preço | categoria 
Implementar filtro de categoria

- Carrinho: Revisar itens | Modificar quantidade | remover produto 
Calcular valor total do pedido

- Testar interface em diferentes navegadore e dispositivos 

## Desenvolvimento do Backend e Banco de Dados
Criar banco de dados:
- Utilizando phpMyAdmin disponivel no XAMPP 
Crie o banco de dados: Cantina

- Criar tabelas essenciais 
Tabela cliente: id_cliente | nome_cliente | cpf_cliente | email_cliente | telefone_cliente | senha_cliente

Tabela Produto: id_produto | id_categoria | nome_produto | descricao_produto | preco_produto | qtd_estoque | img_produto

Tabela Categoria: id_categoria | nome_categoria

Tabela Pedido: id_pedido | id_cliente | status_pedido | total_pedido | data_pedido.

Tabela Itens: id_itens | id_produto | id_pedido | qtd_item | preco_item.


- Desenvolvimento do Backend 
Criar um arquio de configuração php para gerenciar a conexão com o banco de dados

Implementar a lógica para salvar os dados do cadastro do usuario no banco de dados

Implementar a logica para verificar se o email e senha sao validos do login 

Testar para verificar se esta cadastrando corretamente o usuario e armazenando informações no banco

- CRUD de produtos e categorias (Empresa)
Implementar funcionalidade para a empresa adicionar, editar e remover produtos e categorias 

Implementar logica para salvar as informações no banco de dados

Exibir os produtos cadastrados no banco na pagina de cardapio 

- Carrinho de compras (Cliente)
Implementar funcionalidade de adicionar produtos ao carrinho ( use sessões php para armazernar temporariamente )

Criar a pagina de carrinho para exibir os produtos selecionados e valor total 

- Processamento de pagamento 
Implementar integração com o pix para quando o cliente finalizar a comprar exibir codigo pix de pagamento

Atualizar o status do pedido no banco de dados para "Aguardando retirada" apos o pagamento for confirmado

- Geração do Voucher 
Apos pagamento gerar um código unico para retirada do pedido na cantina

Armazenar o voucher no banco de dados na tabela pedido

# Relatório de Vendas (Empresa)

