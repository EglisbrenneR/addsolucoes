<?php
// Defina o e-mail de destino
$to = "add@addsolucoes.com";
$subject = "Novo Orçamento - Add Soluções";

// Recebe os dados do formulário via método POST
$nome = $_POST['nome'];
$email = $_POST['email'];
$servico = $_POST['servico'];
$mensagem = $_POST['mensagem'];

// Configura os cabeçalhos para envio de e-mail em HTML
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: <add@addsolucoes.com>' . "\r\n"; // Remetente do e-mail

// Corpo do e-mail em HTML
$emailContent = "
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='utf-8'>
    <title>Novo Orçamento - Add Soluções</title>
</head>
<body>
    <h2>Solicitação de Orçamento</h2>
    <p><strong>Nome:</strong> $nome</p>
    <p><strong>E-mail:</strong> $email</p>
    <p><strong>Serviço:</strong> $servico</p>
    <p><strong>Mensagem:</strong></p>
    <p>$mensagem</p>
</body>
</html>";

// Envia o e-mail
if (mail($to, $subject, $emailContent, $headers)) {
    echo "Orçamento enviado com sucesso!";
} else {
    echo "Falha ao enviar o orçamento. Por favor, tente novamente.";
}

