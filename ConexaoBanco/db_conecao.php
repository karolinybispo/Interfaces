<!--  -->
$serverName = "localhost"; //servidor do banco de dados
$userServer = "root"; //usuario mysql
$senhaServer= "";
$nomeBanco = "cantina";

$con = mysqli_connect($nomeServer, $userServer, $senhaServer, $nomeBanco);

if (!$con){
    die("falha na conexao " + mysqli_connect_error());
}

echo ( "conexao realizada");