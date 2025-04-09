<?php
include 'db.php';

$especialidade = isset($_GET['especialidade']) ? trim($_GET['especialidade']) : '';

$stmt = $pdo->prepare("SELECT * FROM medico WHERE especialidade LIKE :especialidade");
$stmt->bindValue(':especialidade', '%' . $especialidade . '%');
$stmt->execute();
$medicos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados para <?= htmlspecialchars($especialidade) ?> | Agende Já</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="estiloNovo.css">

    <!-- <style>
        .navbar-custom {
            background: linear-gradient(90deg, #11dadc, #0987d9);
            padding: 20px 0;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: white !important;
            font-size: 1.2rem;
        }

        .navbar-custom .nav-link:hover {
            color: #f8f9fa !important;
        }

        .results-section {
            padding: 50px 0;
        }

        .doctor-card {
            transition: transform 0.3s;
            margin-bottom: 20px;
        }

        .doctor-card:hover {
            transform: scale(1.03);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

    </style> -->
</head>

<body>
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid">
                <a class="navbar-brand" href="Home.php">
                    <img src="imagens/logo.png" alt="" height="50" class="d-inline-block align-top">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="Agendamento.html">Agendar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Login.html">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Usuario.html">Meus Dados</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Seção de Resultados -->
        <section class="results-section">
            <div class="container-fluid">
                <h2 class="titulo-principal">Resultados para "<?= htmlspecialchars($especialidade) ?>"</h2>
                <?php if (count($medicos) > 0): ?>
                    <div class="doctor-grid">
                        <?php foreach ($medicos as $medico): ?>
                            <div class="card doctor-card">
                                <h4 class="titulo-card"><?= htmlspecialchars($medico['nome']) ?></h4>
                                <h6 class="consulta-especialidade"><?= htmlspecialchars($medico['especialidade']) ?></h6>

                                <p class="card-text">
                                    <i class="fas fa-map-marker-alt icone"></i>
                                    <?= htmlspecialchars($medico['endereco_clinica']) ?><br>
                                    <i class="fas fa-phone icone"></i> <?= htmlspecialchars($medico['telefone']) ?><br>
                                    <i class="fas fa-envelope icone"></i> <?= htmlspecialchars($medico['email']) ?>
                                </p>

                                <a href="Medico.php?medico=<?= $medico['crm'] ?>" class="botao">Ver detalhes</a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-warning text-center">
                            <h4>Nenhum médico encontrado para "<?= htmlspecialchars($especialidade) ?>"</h4>
                            <p>Por favor, tente outra especialidade ou verifique a ortografia.</p>
                            <a href="Home.php" class="btn btn-primary">Voltar à página inicial</a>
                        </div>
                    <?php endif; ?>
                </div>
        </section>
   <!-- Footer
   <footer class="footer">
        <div class="container">
            <p>&copy; 2023 Agende Já. Todos os direitos reservados.</p>
        </div>
    </footer> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>