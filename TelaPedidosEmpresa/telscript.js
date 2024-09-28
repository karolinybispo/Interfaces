//JS para abrir e fechar sidebar(barra de navegacao que esta dentro do humburguer) com overlay effect
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
  }
  
  
  function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
  }

  //ACOES PARA BOTAO MOVER OS PEDIDOS ENTRE OS STATUS
  function moverParaFazendo(botao) {
    //pega o pedido correspondente ao botao clicado
    const pedido = botao.parentElement; 

    // Remove o botão "Mover para Fazendo", CRIA um botao dinamico e adiciona um novo botão "Mover Feito"
    botao.remove();
    const botaoFeito = document.createElement('button');
    botaoFeito.textContent = "Mover Feito";
    botaoFeito.classList.add('btn', 'btn-outline-success', 'btn-sm' ); // Adiciona a classe Bootstrap ao botão
    botaoFeito.onclick = function () { moverParaFeito(this) };
    pedido.appendChild(botaoFeito);

    // move pedido para coluna "fazendo"
    const colunaFazendo = document.getElementById('Fazendo');
    colunaFazendo.appendChild(pedido);
  }

  function moverParaFeito(botao){
    //pega o pedido correspondente ao botao clicado
    const pedido = botao.parentElement;

    //remove botao "mover para feito"
    botao.remove();

    //move pedido para coluna feito
    const colunaFeito = document.getElementById('Feito');
    colunaFeito.appendChild(pedido);
  }