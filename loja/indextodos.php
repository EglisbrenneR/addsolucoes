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

// Consulta para obter os produtos com limite e offset
$result_produtos = "SELECT * FROM produto LIMIT $produtos_por_pagina OFFSET $offset";
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
            text-align: center; /* Centraliza o texto */
            padding: 15px; /* Espaçamento interno */
            border: none; /* Remove a borda */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Adiciona sombra */
            height: 350px; /* Altura fixa para todas as thumbnails */
            overflow: hidden; /* Evita que o conteúdo ultrapasse */
        }
        .thumbnail img {
            width: 100%; /* Ajusta a largura da imagem */
            height: 200px; /* Altura fixa para as imagens */
            object-fit: cover; /* Mantém a proporção e cobre o espaço */
            cursor: pointer; /* Muda o cursor para indicar que a imagem é clicável */
        }
        .caption {
            margin-top: 10px; /* Espaço acima da legenda */
        }
        .btn-comprar {
            margin-top: 10px; /* Espaçamento acima do botão */
            width: 100%; /* Botão ocupa toda a largura disponível */
        }
        .pagination {
            display: flex; /* Utiliza flexbox para centralizar */
            justify-content: center; /* Centraliza horizontalmente */
            margin: 20px 0; /* Espaço acima e abaixo da paginação */
        }
        .pagination a {
            margin: 0 5px; /* Espaço entre os botões de página */
            padding: 10px 15px; /* Espaçamento interno dos botões */
            text-decoration: none; /* Remove o sublinhado */
            border: 1px solid #007bff; /* Borda azul */
            color: #007bff; /* Texto azul */
            border-radius: 5px; /* Cantos arredondados */
        }
        .pagination a.active {
            background-color: #007bff; /* Fundo azul quando ativo */
            color: white; /* Texto branco quando ativo */
        }
    </style>
</head>
<body>
    <div class="container theme-showcase" role="main">
        <div class="page-header">
            <h3>NOSSOS PRODUTOS</h3>
        </div>
        <div class="row">
            <?php while($rows_produtos = mysqli_fetch_assoc($resultado_produtos)) { ?>
                <div class="col-sm-5 col-md-3">
                    <div class="thumbnail">
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
                            <?php
                            $whatsappNumber = '+55 88 99790-5780'; // Substitua pelo número do vendedor
                            $productId = $rows_produtos['codigo'];
                            $productName = $rows_produtos['nome'];
                            $message = urlencode("Olá, gostaria de comprar o produto ID: $productId - Nome: $productName");
                            ?>
                            <p>
                                <a href="https://api.whatsapp.com/send?phone=<?php echo $whatsappNumber; ?>&text=<?php echo $message; ?>" 
                                   class="btn btn-primary btn-comprar" role="button" target="_blank">Comprar</a>
                            </p>
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
