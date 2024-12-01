<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "usuario", "senha", "nome_do_banco");

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Recebe os dados do formulário
$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];
$localizacao = $_POST['localizacao'];
$tipo = $_POST['tipo'];
$salario = $_POST['salario'];

// Insere no banco de dados
$sql = "INSERT INTO vagas (titulo, descricao, localizacao, tipo, salario) VALUES ('$titulo', '$descricao', '$localizacao', '$tipo', '$salario')";
if ($conn->query($sql) === TRUE) {
    echo "Vaga cadastrada com sucesso!";
} else {
    echo "Erro: " . $conn->error;
}

// Fecha a conexão
$conn->close();
?>
