<?php include_once("conexao.php");
$result_produtos = "SELECT * FROM produto";
$resultado_produtos = mysqli_query($conexao, $result_produtos);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nossos Produtos</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>

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
    </style>
</head>
<body>
    <div class="container theme-showcase" role="main">
        <div class="page-header">
            <h3>NOSSOS PRODUTOS</h3>
        </div>
        <div class="owl-carousel">
            <?php while($rows_produtos = mysqli_fetch_assoc($resultado_produtos)) { ?>
                <div class="item">
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
                                <a href="https://api.whatsapp.com/send?phone=<?php echo $whatsappNumber; ?>&text=<?php echo $message; ?>" class="btn btn-primary btn-comprar" role="button" target="_blank">Comprar</a>
                            </p>
                        </div>
                    </div>
                </div>
            <?php } ?>
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
        $(document).ready(function(){
            $(".owl-carousel").owlCarousel({
                items: 4, // Número de itens a serem exibidos
                loop: true,
                margin: 10,
                nav: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 4
                    }
                }
            });

            // Script para abrir a imagem no modal
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
