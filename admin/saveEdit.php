<?php

    include_once('functions.php');

    if(isset($_POST['update']))
    {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $telefone = $_POST['telefone'];
        $sexo = $_POST['genero'];
        $data_nasc = $_POST['data_nascimento'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $endereco = $_POST['endereco'];
        $nivel_de_acesso = $_POST['nivel_de_acesso'];

        $sqlUpdate = "UPDATE usuario SET nome='$nome',email='$email',senha='$senha',telefone='$telefone',sexo='$sexo',data_nasc='$data_nasc',cidade='$cidade',estado='$estado',endereco='$endereco',nivel_de_acesso='$nivel_de_acesso'
        WHERE id='$id'";

        $result = $conexao->query($sqlUpdate);
    }
    header('location: usuarios.php');

    /*
    <td><?php if (!empty($produto['imagem'])) { ?>
      <img src="uploads/<?php echo $produto['imagem']; ?>" alt="
      <?php echo $produto['nome']; ?>">
    <?php } ?>
  </td>
  */



?>