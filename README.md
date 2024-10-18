# Interfaces

## Branchs
- main: ficam os arquivos para produção.
- devlop: arquivos recebidos da branch release.
- release: cria, modifica, altera os arquivos.

## Informacoes referente ao front
- no formulario, o **action** deve apontar para o arquivo php que ira processar o envio dos dados.  O action diz para onde os dados do form serao enviados ao ser submetidos.
- no **method** sera definido o metodo HTTP. 

### Metodos HTTP
1. **GET**
- Utilizado para solicitar dados do servidor.
- Não modifica o estado do servidor, apenas recupera informações.
- Exemplo: Obter uma lista de produtos.

2. **POST**
- Envia dados ao servidor para criar ou processar um novo recurso.
- Comumente utilizado para formulários de cadastro.
- Exemplo: Registrar um novo usuário.

3. **PUT**
- Substitui o recurso no servidor com os dados enviados.
- Utilizado para atualizar completamente um recurso existente.
- Exemplo: Atualizar as informações de um produto.

4. **PATCH**
- Similar ao `PUT`, mas utilizado para atualizações parciais de um recurso.
- Exemplo: Alterar apenas o preço de um produto.

**DELETE**
- Remove um recurso do servidor.
- Exemplo: Excluir uma conta de usuário.