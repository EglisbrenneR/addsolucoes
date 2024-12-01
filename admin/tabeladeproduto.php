<?php
    include_once('functions.php');
    //print_r($_SESSION['usuario']);

    $sql = "SELECT * FROM produto ORDER BY id DESC";
    $result = $connect->query($sql);
    
   

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>ADD SOLUÇÕES</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="assets/css/demo.css" />
  </head>
  <body>

      <div class="main-panel">
        <div class="main-header">
        </div>

          <div class="page-inner">
          <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div class="ms-md-auto py-2 py-md-0">
                <a href="cadproduto.php" class="btn btn-label-info btn-round me-2">CADASTRAR PRODUTOS</a>
                <a href="sair.php" class="btn btn-primary btn-round">SAIR</a>
              </div>
            </div>
            <?php
              $tabela = "produto";
              $order = "";
              $produtos = buscar($connect, $tabela, 1,$order);
              if (isset($_GET['id'])) { ?>
                  <h2>Tem Certeza que deseja excluir o produto? <?php echo $_GET['nome']; ?></h2>
                  <form action="tabeladeproduto.php" method="post">
                      <input type="hidden" name="id" value="<?php echo $_GET['id']?>">
                      <input type="submit" name="deletar" value="Deletar">
                  </form>
              <?php } 

                  if (isset($_POST['deletar']) AND !empty($_POST['id'])){
                      deletar($connect, "produto", $_POST['id']);
                  }
              ?>
            <div class="row">
                     <!--começo tabela de usuario -->
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">PRODUTOS CADASTRADOS</div>
                  </div>
                  <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">IMAGEM</th>
                                <th scope="col">NOME</th>
                                <th scope="col">CODIGO</th>
                                <th scope="col">DESCRIÇÃO</th>
                                <th scope="col">PROMOÇÃO</th>
                                <th scope="col">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produtos as $produto) : ?>
                            <tr>
                                <td><?php echo $produto['id']; ?></td>
                                <td>
                                    <img width="80px" src="imagens/uploads/<?php echo $produto['imagem']; ?>" alt="
                                    <?php echo $produto['imagem']; ?>">
                                </td>
                                <td><?php echo $produto['nome']; ?></td>
                                <td><?php echo $produto['codigo']; ?></td>
                                <td><?php echo $produto['descricao']; ?></td>
                                <td><?php echo $produto['promocao']; ?></td>
                                <td>
                                        <a class='btn btn-sm btn-primary' href ="cadproduto.php?id=<?php echo $produto['id']; ?>&nome=<?php echo $produto['nome']; ?>  ">
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                            <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325'/>
                                            </svg>
                                        </a>
                                        <a class='btn btn-sm btn-danger' href ="tabeladeproduto.php?id=<?php echo $produto['id']; ?>&nome=<?php echo $produto['nome']; ?>  ">
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                            <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0'/>
                                            </svg>
                                        </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
  </body>
</html>
