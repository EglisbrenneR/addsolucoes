<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>teste</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="text" name="nome" placeholder="Seu nome">
            <input type="file" name="arquivo">
            <input type="submit" name="enviar">



        </form>
        <?php
        function uploadImagem($caminho){
            if(isset($_POST['enviar'])){
                //print_r($_FILES['arquivo']);
                if (! empty($_FILES['arquivo']['name'])){

                $nomeArquivo = $_FILES['arquivo']['name'];
                $tipo = $_FILES['arquivo']['type'];
                $nomeTemporario = $_FILES['arquivo']['tmp_name'];
                $tamanho = $_FILES['arquivo']['size'];
                $erros = array();

                $tamanhoMaximo = 1024 * 1024 * 5; //5MB
                if ($tamanho >  $tamanhoMaximo) {
                    $erros[] = "Seu arquivo excede o tamanho maximo<br>";
                }

                $arquivoPermitidos = ["png", "jpeg","jpg"];
                $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);
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
                    $caminho = "imagens/uploads/";   
                    $hoje  = date ("d-m-y_h");
                    $novoNome = $hoje. "-" .$nomeArquivo;
                   if (move_uploaded_file($nomeTemporario, $caminho.$novoNome)){
                    echo "Upload feito com sucesso";
                   }else{
                    echo "Erro ao enviar o arquivo";
                   }
                
                }


             } 
            
            }
        }

        ?>



<?php
    include_once('functions.php');

    $nome = $_POST['nome'];
    $imagem = $_POST['imagem'];
    $codigo = $_POST['codigo'];
    $descricao = $_POST['descricao'];
    $promocao = $_POST['promocao'];

    $result = mysqli_query($connect, "INSERT INTO produto (nome,imagem,codigo,descricao,promocao) 
    VALUES ('$nome','$imagem','$codigo','$descricao','$promocao')");

    header('Location: cadproduto.php');

    $imagem = !empty($_FILES['imagem']['name']) ? $_FILES['imagem']['name']: "";
    if (!empty($imagem)){
        $caminho = "imagens/uploads/";
       $imagem =  UploadImage($caminho);
    }

    if (isset($_POST['enviar'])) {
        //print_r($_FILES['imagem']);
        echo $_FILES ['imagem']['name'];
      }
?>




    </body>
</html>