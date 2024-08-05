<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/libs/vendor/autoload.php';

$mail = new PHPMailer(true);

try {
   
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Username = '46e6b5316e54c6';  
    $mail->Password = 'b7e724d87f9453';  
    $mail->Port = 2525;

    
    $mail->setFrom('alexandre.dantas0013@gmail.com', 'Alex');
    $mail->addAddress('joceni406@gmail.com', 'Alexsander');

    
    $nome = trim($_POST['nome']);
    $uf = trim($_POST['uf']);
    $telefone = trim($_POST['telefone']);
    $email = trim($_POST['email']);
    $valor = trim($_POST['valor']);
    $processo = trim($_POST['processo']);

    $errors = [];

    // Validação do nome
    if (empty($nome)) {
        $errors[] = 'O nome é obrigatório.';
    }

    // Validação da UF
    if (empty($uf)) {
        $errors[] = 'O Estado/UF é obrigatório.';
    }

    // Validação do telefone
    if (empty($telefone)) {
        $errors[] = 'O telefone é obrigatório.';
    }

    // Validação do email
    if (empty($email)) {
        $errors[] = 'O email é obrigatório.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Formato de email inválido.';
    }

    // Validação do valor do precatório
    if (empty($valor)) {
        $errors[] = 'O valor do precatório é obrigatório.';
    }

    // Validação do número do processo
    if (empty($processo)) {
        $errors[] = 'O número do processo é obrigatório.';
    }

    if (empty($errors)) {
        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Dados do Formulário';
        $mail->Body    = "
            <p><strong>Nome:</strong> $nome</p>
            <p><strong>Estado/UF:</strong> $uf</p>
            <p><strong>Telefone:</strong> $telefone</p>
            <p><strong>E-mail:</strong> $email</p>
            <p><strong>Valor do precatório:</strong> $valor</p>
            <p><strong>Número do processo:</strong> $processo</p>
        ";
        $mail->AltBody = "
            Nome: $nome
            Estado/UF: $uf
            Telefone: $telefone
            E-mail: $email
            Valor do precatório: $valor
            Número do processo: $processo
        ";

       
        $mail->send();
        echo '<p class="text-success">Formulário enviado com sucesso!</p>';
    } else {
        foreach ($errors as $error) {
            echo '<p class="text-danger">' . $error . '</p>';
        }
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
