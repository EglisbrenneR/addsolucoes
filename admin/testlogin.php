<?php
    session_start();
    //print_r($_REQUEST);

    if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha']))
    {
       //Acessa
       include_once('config.php');
       $email = $_POST ['email'];
       $senha = $_POST ['senha'];

       //print_r('Email:' . $email);
       //print_r('<br>');
       //print_r('Senha:' . $senha);

       $sql = "SELECT * FROM usuario WHERE email = '$email' and senha = '$senha'";

       
    //  $host = 'localhost';
    //  $name = 'dbadd';
    //  $user = 'root';
    //  $pass = '';

    //    try {
    //     self::$connect = new \PDO('mysql:host=' .  $host . ';dbname=' . $name . ';charset=utf8', $user, $pass);
    //     return self::$connect;
    // } catch (\PDOException $e) {
    //     echo 'error' . $e;
    // }

       $execute = mysqli_query($conexao, $sql);
       $result = mysqli_fetch_all($execute, MYSQLI_ASSOC);

       //print_r($sql);
       //print_r($result);

       if(count($result) == 0)
       {
            unset($_SESSION['usuario']['email']);
            unset($_SESSION['usuario']['senha']); 
            header('Location: login.php');
       }
       else
       {
            $_SESSION['usuario'] = [
                'id'        => $result[0]['id'],
                'email'     => $result[0]['email'],
                'nome'      => $result[0]['nome'],
                'imagem'    =>'' /* $testeLogin[0]['anexo'] */,
                'logado'    => true,
                'acesso'    => $result[0]['nivel_de_acesso']
            ];
            

            header('Location: sistema.php');
       }
    }
    else
    {
        // Não acessa 
        header('Location: login.php');
    }


?>