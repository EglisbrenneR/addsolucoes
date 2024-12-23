<?php
include_once('functions.php');

// Verifica se a conexão está ativa
if (!$connect) {
    die("Erro ao conectar com o banco de dados: " . mysqli_connect_error());
}

// Captura os dados do formulário
$id = isset($_POST['id']) ? $_POST['id'] : null;
$nome = isset($_POST['nome']) ? mysqli_real_escape_string($connect, $_POST['nome']) : null;
$codigo = isset($_POST['codigo']) ? mysqli_real_escape_string($connect, $_POST['codigo']) : null;
$descricao = isset($_POST['descricao']) ? mysqli_real_escape_string($connect, $_POST['descricao']) : null;
$promocao = isset($_POST['promocao']) ? mysqli_real_escape_string($connect, $_POST['promocao']) : null;
$imagem = !empty($_FILES['imagem']['name']) ? $_FILES['imagem']['name'] : "";

// Faz upload da imagem, se existir
if (!empty($imagem)) {
    $caminho = "imagens/uploads/";
    $imagem = UploadImage($caminho);
}

// Define a consulta SQL para inserção ou atualização
if ($id) {
    // Atualização
    $sql = "UPDATE produto SET 
                nome = '$nome', 
                codigo = '$codigo', 
                descricao = '$descricao', 
                promocao = '$promocao'";
    
    // Atualiza a imagem somente se for enviada
    if ($imagem) {
        $sql .= ", imagem = '$imagem'";
    }

    $sql .= " WHERE id = $id";
} else {
    // Inserção
    $sql = "INSERT INTO produto (nome, imagem, codigo, descricao, promocao) 
            VALUES ('$nome', '$imagem', '$codigo', '$descricao', '$promocao')";
}

// Executa a consulta
if (mysqli_query($connect, $sql)) {
    header('Location: cadproduto.php');
    exit;
} else {
    echo "Erro ao executar a consulta: " . mysqli_error($connect);
}
?>
