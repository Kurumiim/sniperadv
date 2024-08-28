<?php 
require_once("conexao.php");

$senha = filter_var(@$_POST['senha'], @FILTER_SANITIZE_STRING);
$re_senha = filter_var(@$_POST['re_senha'], @FILTER_SANITIZE_STRING);
$token = filter_var(@$_POST['token'], @FILTER_SANITIZE_STRING);
$email = filter_var(@$_POST['email'], @FILTER_SANITIZE_STRING);

$_SESSION['temp_reset_email'] = $_REQUEST['email'];
$_SESSION['temp_reset_token'] = $_REQUEST['token'];

if($senha != $re_senha){
     echo 'As senhas são diferentes!!';
     exit();
}

        $senha = password_hash($senha, PASSWORD_DEFAULT);

          $query = $pdo->prepare("UPDATE usuarios SET senha_crip = :senha, token = :token WHERE email = :email");

               $query->bindValue(":senha", "$senha");
               $query->bindValue(":token", "$token");
               $query->bindValue(":email", "$email");
               $query->execute();

        echo 'Senha alterada com Sucesso';


?>