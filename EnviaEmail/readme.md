# Processo seguidos para conseguir enviar email ao usuario com o vaucher

## PHPMailer é uma biblioteca popular para envio de e-mails em PHP. Ele simplifica o processo de envio de mensagens, oferecendo uma interface poderosa e flexível para configurar e enviar e-mails por meio de servidores SMTP, com suporte para autenticação, anexos e mensagens em HTML. 

1. Acesse o repositório oficial do PHPMailer no GitHub: PHPMailer no GitHub.
2. Clique em Code > Download ZIP.
3. Extraia os arquivos e copie a pasta para o diretório do seu projeto.
4. Inclua os arquivos manualmente no inicio do script PHP que enviara o e-mail (substitua path/to/PHPMailer pelo caminho exato onde estao os arquivos da pasta PHPMailer):
    require 'path/to/PHPMailer/src/PHPMailer.php';
    require 'path/to/PHPMailer/src/SMTP.php';
    require 'path/to/PHPMailer/src/Exception.php';
