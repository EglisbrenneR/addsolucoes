<?php 
include_once("conexao.php");

// Define quantos produtos mostrar por página
$produtos_por_pagina = 20;

// Obtém o número da página atual da URL, se não existir, define como 1
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_atual - 1) * $produtos_por_pagina;

// Consulta para contar o total de produtos
$result_count = "SELECT COUNT(*) AS total FROM produto";
$resultado_count = mysqli_query($conexao, $result_count);
$total_produtos = mysqli_fetch_assoc($resultado_count)['total'];

// Consulta para obter os produtos com limite e offset, ordenando disponíveis primeiro
$result_produtos = "
    SELECT * 
    FROM produto 
    ORDER BY (promocao = 'Não') ASC 
    LIMIT $produtos_por_pagina 
    OFFSET $offset";
$resultado_produtos = mysqli_query($conexao, $result_produtos);

$total_paginas = ceil($total_produtos / $produtos_por_pagina);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nossos Produtos</title>

    <style>
        .thumbnail {
            text-align: center;
            padding: 15px;
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            height: 350px;
            overflow: hidden;
        }
        .thumbnail img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            cursor: pointer;
        }
        .caption {
            margin-top: 10px;
        }
        .btn-comprar {
            margin-top: 10px;
            width: 100%;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .pagination a {
            margin: 0 5px;
            padding: 10px 15px;
            text-decoration: none;
            border: 1px solid #007bff;
            color: #007bff;
            border-radius: 5px;
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
        }
        .indisponivel {
            opacity: 0.5;
            pointer-events: none;
        }
        .btn-indisponivel {
            background-color: #ccc;
            color: #666;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container theme-showcase" role="main">
        <div class="page-header">
            <h3>NOSSOS PRODUTOS</h3>
        </div>
        <div class="row">
            <?php while ($rows_produtos = mysqli_fetch_assoc($resultado_produtos)) { 
                $indisponivel = $rows_produtos['promocao'] == 'Não'; // Verifica se o produto está indisponível
            ?>
                <div class="col-sm-5 col-md-3">
                    <div class="thumbnail <?php echo $indisponivel ? 'indisponivel' : ''; ?>">
                        <img src="<?php echo 'admin/imagens/uploads/' . htmlspecialchars($rows_produtos['imagem']); ?>" 
                             alt="<?php echo htmlspecialchars($rows_produtos['nome']); ?>" 
                             data-bs-toggle="modal" 
                             data-bs-target="#imageModal" 
                             data-img-src="<?php echo 'admin/imagens/uploads/' . htmlspecialchars($rows_produtos['imagem']); ?>" 
                             data-nome="<?php echo htmlspecialchars($rows_produtos['nome']); ?>" 
                             data-descricao="<?php echo htmlspecialchars($rows_produtos['descricao']); ?>">
                        <div class="caption">
                            <a href="detalhes.php?id_curso=<?php echo htmlspecialchars($rows_produtos['id']); ?>">
                                <h5><?php echo htmlspecialchars($rows_produtos['nome']); ?></h5>
                            </a>
                            <?php if (!$indisponivel) { ?>
                                <p>
                                    <a href="https://api.whatsapp.com/send?phone=<?php echo $whatsappNumber; ?>&text=Olá, gostaria de comprar o produto ID: <?php echo $rows_produtos['codigo']; ?> - Nome: <?php echo $rows_produtos['nome']; ?>" 
                                       class="btn btn-primary btn-comprar" role="button" target="_blank">Comprar</a>
                                </p>
                            <?php } else { ?>
                                <p>
                                    <button class="btn btn-indisponivel" disabled>Indisponível</button>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Paginação -->
        <div class="pagination">
            <?php if ($pagina_atual > 1): ?>
                <a href="?pagina=<?php echo $pagina_atual - 1; ?>">&laquo; Anterior</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <a href="?pagina=<?php echo $i; ?>" class="<?php echo ($i == $pagina_atual) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
            <?php if ($pagina_atual < $total_paginas): ?>
                <a href="?pagina=<?php echo $pagina_atual + 1; ?>">Próximo &raquo;</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal para exibir a imagem ampliada -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Imagem do Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="" class="img-fluid">
                    <h5 id="modalProductName" class="mt-3"></h5>
                    <p id="modalProductDescription"></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        // Script para abrir a imagem no modal
        $(document).ready(function() {
            $('#imageModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Botão que acionou o modal
                var imgSrc = button.data('img-src'); // Extraindo o src da imagem
                var productName = button.data('nome'); // Extraindo o nome do produto
                var productDescription = button.data('descricao'); // Extraindo a descrição do produto
                
                var modalImage = $(this).find('#modalImage'); // Selecionando a imagem do modal
                var modalProductName = $(this).find('#modalProductName'); // Selecionando o nome do produto
                var modalProductDescription = $(this).find('#modalProductDescription'); // Selecionando a descrição do produto
                
                modalImage.attr('src', imgSrc); // Definindo o src da imagem no modal
                modalProductName.text(productName); // Definindo o nome do produto no modal
                modalProductDescription.text(productDescription); // Definindo a descrição do produto no modal
            });
        });
    </script>
</body>
</html>
