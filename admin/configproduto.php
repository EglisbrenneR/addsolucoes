<?php
    include_once('functions.php');

    $nome = $_POST['nome'];
    $imagem = $_FILES['imagem'];
    $codigo = $_POST['codigo'];
    $descricao = $_POST['descricao'];
    $promocao = $_POST['promocao'];


    // echo '<pre>';
    // var_dump( $_FILES['imagem']);
    // echo '</pre>';
    // exit;
//     echo '<pre>';
// print_r($array);
// echo '</pre>';
// echo '<pre>';
// print_r(debug_backtrace());
// echo '</pre>';

    $imagem = !empty($_FILES['imagem']['name']) ? $_FILES['imagem']['name']: "";
    if (!empty($imagem)){
        $caminho = "imagens/uploads/";
        $imagem =  UploadImage($caminho);
    }

    if($imagem != false){
        $query = mysqli_query($connect, "INSERT INTO produto (nome,imagem,codigo,descricao,promocao) 
        VALUES ('$nome','$imagem','$codigo','$descricao','$promocao')");
    }else{
        $query = mysqli_query($connect, "INSERT INTO produto (nome,,codigo,descricao,promocao) 
        VALUES ('$nome','$codigo','$descricao','$promocao')");
    }


    header('Location: cadproduto.php');