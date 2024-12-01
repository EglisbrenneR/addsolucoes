<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Add Soluções - Vagas de Emprego</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/icon.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-dark px-5 py-3 py-lg-0">
            <a href="index.php" class="navbar-brand p-0">
                <img src="img/logo4.png" width="120" height="40" alt="Logo" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="index.php" class="nav-item nav-link">Inicio</a>
                    <a href="sobre.php" class="nav-item nav-link">Sobre</a>
                    <a href="servicos.php" class="nav-item nav-link">Serviços</a>
                    <a href="vagas.php" class="nav-item nav-link active">Vagas</a>
                    <a href="contato.php" class="nav-item nav-link">Contato</a>
                </div>
            </div>
        </nav>

        <div class="container-fluid bg-primary py-5 bg-header" style="margin-bottom: 90px;">
            <div class="row py-5">
                <div class="col-12 text-center">
                    <h1 class="display-4 text-white">Vagas de Emprego</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Vagas Section Start -->
    <div class="container py-5">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h5 class="fw-bold text-primary text-uppercase">Oportunidades</h5>
            <h1 class="mb-0">Encontre a vaga ideal para você</h1>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="job-item bg-light p-4 rounded">
                    <h4 class="text-primary">Desenvolvedor Web</h4>
                    <p><i class="fa fa-map-marker-alt text-primary me-2"></i>Remoto</p>
                    <p><i class="fa fa-calendar-alt text-primary me-2"></i>Integral</p>
                    <p><i class="fa fa-dollar-sign text-primary me-2"></i>R$ 4.000 - R$ 6.000</p>
                    <a href="#" class="btn btn-primary mt-3">Mais Informações</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="job-item bg-light p-4 rounded">
                    <h4 class="text-primary">Analista de Suporte</h4>
                    <p><i class="fa fa-map-marker-alt text-primary me-2"></i>Brejo Santo, CE</p>
                    <p><i class="fa fa-calendar-alt text-primary me-2"></i>Presencial</p>
                    <p><i class="fa fa-dollar-sign text-primary me-2"></i>R$ 2.500 - R$ 3.500</p>
                    <a href="#" class="btn btn-primary mt-3">Mais Informações</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="job-item bg-light p-4 rounded">
                    <h4 class="text-primary">Estagiário de TI</h4>
                    <p><i class="fa fa-map-marker-alt text-primary me-2"></i>Fortaleza, CE</p>
                    <p><i class="fa fa-calendar-alt text-primary me-2"></i>Meio Período</p>
                    <p><i class="fa fa-dollar-sign text-primary me-2"></i>Bolsa: R$ 1.000</p>
                    <a href="#" class="btn btn-primary mt-3">Mais Informações</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Vagas Section End -->

    <!-- Footer -->
    <?php include_once "footer.php"; ?>
    
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i class="bi bi-arrow-up"></i></a>
</body>

</html>
