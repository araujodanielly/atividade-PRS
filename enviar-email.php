<!DOCTYPE html>
<html lang="pt-br">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>E-mails com PHP</title>
<link rel="stylesheet" href="formata-email.css">
</head>
<body>
  <h1> Envio automático de e-mails com PHP - servidor do Google </h1>

  <form action="enviar-email.php" method="post">
   <fieldset>
    <legend> Cadastro de usuário </legend>
    <label class="alinha"> Nome: </label>
    <input type="text" name="nome"><br>

    <label class="alinha"> Data de nascimento: </label>
    <input type="date" name="data-nascimento"><br>

    <label class="alinha"> E-mail: </label>
    <input type="email" name="email"><br>

    <div class="botao">
      <button name="cadastrar">Cadastrar usuário</button>
    </div>
   </fieldset>
  </form>
 
  <?php
   //configuracao inicial para começarmos a usar o framework
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;

   require "./PHPMailer/src/Exception.php";
   require "./PHPMailer/src/PHPMailer.php";
   require "./PHPMailer/src/SMTP.php";

   if(isset($_POST['cadastrar'])){
    $nome = $_POST['nome'];
    $dataNascimento = $_POST['data-nascimento'];
    $email = $_POST['email'];

    //vamos, usando a classe PHPMailer, criar o objeto $objEmail
    $objEmail = new PHPMailer();
    
    //abaixo, comandos do framework para evitarmos problemas de acentuação no e-mail
    $objEmail->CharSet = "UTF-8";
    $objEmail->setLanguage("pt-br");

    //configurações do servidor de email do remetente
    $objEmail->Host = "smtp.gmail.com";
    $objEmail->Username = "remetente.ifsc2016@gmail.com";
    $objEmail->Password = "rdye xans iaej eney"; 
    $objEmail->Port = 465; 
    $objEmail->SMTPSecure = "ssl"; 
    $objEmail->isSMTP(); 
    $objEmail->SMTPAuth = true;

    //configurações dos dados da mensagem
    $objEmail->isHTML(true); //mensagem com HTML no corpo
    $objEmail->Subject = "Resultado do cadastro"; //assunto do email
    //dados do e-mail do remetente
    $objEmail->addReplyTo("remetente.ifsc2016@gmail.com", "Administrador"); 

    $objEmail->setFrom("remetente.ifsc2016@gmail.com", "Administrador"); //de onde esta vindo o email

    $objEmail->AddAddress($email, $nome,); //endereços de email de quem vai receber nossa mensagem
    
    //definição do corpo da mensagem

    $objEmail->Body = "<h1 style='color: green'> Prezado cliente, confira, a seguir, seus dados cadastrais em nossa aplicação web: </h1>
    <p>Nome: $nome <br>
       Data de nascimento: $dataNascimento <br>
       E-mail: $email</p>";

    //enviando arquivos em anexo
    $objEmail->AddAttachment("anexo1.pdf");
    $objEmail->AddAttachment("anexo2.doc");

    if($objEmail->Send()){
     echo "<p>Cadastro na aplicação web cadastrado com sucesso. Prezado cliente acesse sua conta de e-mail e confira seus dados. Qualquer dúvida, entre em contato. </p>";
    }
    else{ 
     echo "<p>Erro no envio do e-mail: código do erro $objEmail->ErrorInfo</p>";
    }
   }
  ?>
</body>
</html>