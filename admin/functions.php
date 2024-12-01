<?php

$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "dbadd";

$connect = mysqli_connect( $host, $db_user, $db_pass, $db_name);

function login($connect){
    if(isset($_POST['acessar']) AND !empty($_POST['email']) AND !empty($_POST['senha'])){

        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $senha =sha1($_POST['senha']);
        $query = "SELECT *FROM usuario WHERE email = '$email' AND senha = '$senha' ";
        $executar = mysqli_query($connect, $query);
        $return = mysqli_fetch_assoc ($executar);

        if(!empty($return['email'])){
        //echo "BEM-VINDO " .$return['nome'];
        session_start();
        $_SESSION['usuario']['nome'] = $return['nome'];
        $_SESSION['usuario']['id'] = $return['id'];
        $_SESSION['usuario']['ativa'] = TRUE;
        header("location: sistema.php");

        }else{
            echo "Usuario ou senha não encontrado!";
        }
    }
}
function logout(){
    session_start();
    session_unset();
    session_destroy();
    header("location: login.php");
}
/* Seleciona (busca) no BD apenas um resultado com base no ID*/
function buscaUnica($connect, $tabela, $id){
    $query = "SELECT * FROM $tabela WHERE id =" . (int) $id;
    $execute = mysqli_query($connect, $query);
    $result = mysqli_fetch_assoc($execute);
    return $result;
}
/* Seleciona (busca) no BD todos os resultado com base no WHERE*/
function buscar($connect, $tabela, $where = 1, $order = "" ){
    if (!empty($order)){
        $order = "ORDER BY $order";
    }

    $query = "SELECT * FROM $tabela WHERE $where $order";
    $execute = mysqli_query($connect, $query);
    $results = mysqli_fetch_all($execute, MYSQLI_ASSOC);
    return $results;

}
/* Inserir Novos Usuarios*/
function inserirUsuarios($connect){

    if ((isset($_POST['cadastrar']) AND !empty($_POST['email']) AND !empty($_POST['senha'])) ){
        $erros = array();
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $nome = mysqli_real_escape_string($connect, $$_POST['nome']);
        $senha = sha1($_POST['senha']);

        if ($_POST['senha'] != $_POST['repetesenha']){
            $erros[] = "Senhas Não conferem!";
        }
        $queryEmail = "SELECT email FROM usuario WHERE email = '$email' ";
        $buscaEmail = mysqli_query($connect, $queryEmail);
        $verifica = mysqli_num_rows($buscaEmail);


        if (!empty($verifica)){
            $erros[] = "Email já Cadastrado!";
        }
        if (empty($erros)) {
            //Inseriri o usuario no BD
            $query = "INSERT INTO usuario (nome, email, senha, data_cadastro) VALUES ('$nome','$email','$senha',NOW()) ";
            $executar = mysqli_query($connect, $query);
            if ($executar) {
               echo "Usuario Inserido Com Sucesso!";
            }else{
                echo "Erro ao Inserir Usuário!";
            }

        }else{
            foreach($erros as $erro ){
                echo "<p>$erro</p>";
            }
        }
    }
}

//Deletar algun dado
function deletar($connect, $tabela, $id){
    if (!empty($id)) {
    $query = "DELETE FROM $tabela WHERE id =". (int) $id;
    $execute = mysqli_query($connect, $query);
    if ($execute) {
        echo "Dado deletado Com Sucesso!";
     }else{
         echo "Erro ao deletar!";
     }

    }
}
function updateUser($connect){
    if (isset($_POST['atualizar']) AND !empty($_POST['email'])){
        $erros = array();
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $nome = mysqli_real_escape_string($connect, $$_POST['nome']);
        $senha = sha1($_POST['senha']);
        $data = mysqli_real_escape_string($connect, $$_POST['data_cadastro']);

        if (empty($data)) {
           $erros[] = " Preencha a data de cadastro";
        }
        if (empty($email)) {
            $erros[] = " Preencha seu E-mail corretamente";
         }
        if (strlen($nome) < 4) {
            $erros[] = " preencha seu nome completo";
         }
        if (!empty($_POST['senha'])) {
            if ($_POST['senha'] == $_POST['repetesenha']){
                $senha = sha1 ($_POST['senha']);
                $erros[] = "Senhas Não conferem!";
            }else{
                $erros[] = "Senhas Não conferem!";
            }
        }
        $queryEmailAtual = "SELECT email FROM usuario WHERE id = '$id' ";

        $buscaEmailAtual = mysqli_query($connect, $queryEmailAtual);

        $retornoEmail = mysqli_fetch_assoc($buscaEmailAtual);

        $queryEmail = "SELECT email FROM usuario WHERE email = '$email' email AND <> '". $retornoEmail['email']."'";

        $buscaEmail = mysqli_query($connect, $queryEmail);

        $verifica = mysqli_num_rows($buscaEmail);

        if (!empty($verifica)){
            $erros[] = "Email já Cadastrado!";
        }
        if (empty($erros)){
        //UPDATE usuario
        if (!empty( $senha)) {
            $query = "UPDATE usuario SET nome = '$nome', email = '$email', senha = '$senha', data_cadastro = '$data' WHERE id =" . $id;
        }else{
            $query = "UPDATE usuario SET nome = '$nome', email = '$email', data_cadastro = '$data' WHERE id =" . $id;

        }
        
        $executar = mysqli_query($connect, $query);
        if ($executar) {
           echo "Usuario Atualizado Com Sucesso!";
        }else{
            echo "Erro ao Atualizar Usuário!";
        }

        }else{
            foreach($erros as $erro){
                echo "<p>$erro</p>";
            }
        }

        
    }
}
function insertProduto($connect){
    if((isset($_POST['insert']) AND !empty($_POST['nome']) AND !empty($_POST['codigo'])) ){

      
        $nome = mysqli_real_escape_string($connect, $_POST['nome']);
        $codigo = mysqli_real_escape_string($connect, $_POST['codigo']);
        $descricao = mysqli_real_escape_string($connect, $_POST['descricao']);
        $promocao = mysqli_real_escape_string($connect, $_POST['promocao']);

        $imagem = !empty($_FILES['imagem']['name']) ? $_FILES['imagem']['name'] : "";
        $retornoUpload = "";
        if (!empty($imagem)) {
            $caminho = "imagens/uploads/";
            $retornoUpload = uploadImage($caminho);
            if (is_array($retornoUpload)) {
                foreach($retornoUpload as $erro){
                    echo $erro;
                }
                $imagem = "";
            }else{
                $imagem = $retornoUpload;
            }

        }

        $query = "INSERT INTO produto (imagem,nome,codigo,descricao,promocao) 
        VALUES ('$imagem','$nome','$codigo','$descricao','$promocao') ";

        $executar = mysqli_query($connect, $query);
        if ($executar) {
            header("location: cadproduto.php ");
        }else{
            echo "Erro ao inserir Produto!";
        }

    }
}
function updateProduto($connect){
    if((isset($_POST['update']) AND !empty($_POST['nome']) AND !empty($_POST['descricao'])) ) {

        $id =(int) $_POST['id'];
        $nome = mysqli_real_escape_string($connect, $_POST['nome']);
        $codigo = mysqli_real_escape_string($connect, $_POST['codigo']);
        $descricao = mysqli_real_escape_string($connect, $_POST['descricao']);
        $promocao = mysqli_real_escape_string($connect, $_POST['promocao']);


        $imagem = !empty($_FILES['imagem']['name']) ? $_FILES['imagem']['name'] : "";
        $retornoUpload = "";
        if (!empty($imagem)) {
            $caminho = "imagens/uploads/";
            $retornoUpload = uploadImage($caminho);
            if (is_array($retornoUpload)) {
                foreach($retornoUpload as $erro){
                    echo $erro;
                }
                $imagem = "";
            }else{
                $imagem = $retornoUpload;
            }

        }

        if(!empty($id)){
            if (!empty($imagem)) {
                $query = "UPDATE produto SET imagem = '$imagem', nome = '$nome', codigo = '$codigo', descricao = '$descricao', promocao = '$promocao' WHERE id = $id";
            }else{
                $query = "UPDATE produto SET nome = '$nome', codigo = '$codigo', descricao = '$descricao', promocao = '$promocao' WHERE id = $id";
            }
        
        $executar = mysqli_query($connect, $query);
        if ($executar) {
            if (is_array($retornoUpload)) {
                echo " Item atualizado com sucesso! Porem a imagem não pode ser inserida!";
            }
            header("location: cadproduto.php ");
        }else{
            echo "Erro ao inserir Usuario!";
        }
      }

    }
}
function uploadImage($caminho){

        if (! empty($_FILES['imagem']['name'])){

            $nomeImagem = $_FILES['imagem']['name'];
            $tipo = $_FILES['imagem']['type'];
            $nomeTemporario = $_FILES['imagem']['tmp_name'];
            $tamanho = $_FILES['imagem']['size'];
            $erros = array();

            $tamanhoMaximo = 1024 * 1024 * 5; //5MB
            if ($tamanho >  $tamanhoMaximo) {
                $erros[] = "Seu arquivo excede o tamanho maximo<br>";
            }

            $arquivoPermitidos = ["png", "jpeg","jpg"];
            $extensao = pathinfo($nomeImagem, PATHINFO_EXTENSION);
            if ( !in_array($extensao, $arquivoPermitidos)){
                $erros[] = "Arquivo não permitido.<br>";

            }
            
            $typesPermitidos = ["image/png", "image/jpeg","image/jpg"];
            if ( !in_array($tipo, $typesPermitidos)){
                $erros[] = "Tipo de arquivo não permitido.<br>";

            }

            if(!empty($erros )) {
                foreach ($erros as $erro){
                    echo $erro;
                }
            }else {

                $hoje  = date ("d-m-y_h");
                $novoNome = $hoje. "-" .$nomeImagem;
            if (move_uploaded_file($nomeTemporario, $caminho.$novoNome)){
                return $novoNome;
            }else{
                return FALSE;
            }
            
            }


        } 
    
    }
