#   Codigos comentados


## db_conexao.php

         <?php
         $nomeServer = "localhost"; //servidor do banco de dados
         $userServer = "root"; //usuario mysql
         $senhaServer= "";
         $nomeBanco = "cantina";

         $mySqli = new mysqli($nomeServer, $userServer, $senhaServer, $nomeBanco);
         //classe mysqli faz conexao entre o PHP e um bd MYSQL.
         //classe mysqli serve para fazer conexao com BD MYSQL + conseguir fazer operacoes SQL no PHP + interagir com BD MYSQL. Ela É a ponte entre codigo PHP e BD

         // Verificar se a conexão foi bem-sucedida
         if ($mySqli->connect_error) {
            die("Conexão falhou: " . $mySqli->connect_error);
         } 
         ?>
         //http://localhost/interfaces/conexaoBanco/db_conexao.php essa url é usada para verificar se o banco faz conexao corretamente.
         // A condicao que informa ao user se esta tudo certo:
               //      if ($mySqli->connect_error) {
               //      die("Conexão falhou: " . $mySqli->connect_error);
               //          } else {
               //          echo "Conexão bem-sucedida!";
               //          }