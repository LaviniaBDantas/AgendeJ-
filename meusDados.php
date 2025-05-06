<?php
session_start();
include "db.php";

$isMedico = isset($_SESSION['crm']);
$isPaciente = isset($_SESSION['cpf']);

if (!$isMedico && !$isPaciente) {
    header("Location: tipoUsuario.php");
    exit();
}

// Se paciente estiver logado
if (isset($_SESSION['cpf'])) {
    $cpf = $_SESSION['cpf'];
    $sql = "SELECT * FROM consulta WHERE cpf_paciente = '$cpf'";
    $result = $pdo->query($sql);

    $sqlPaciente = "SELECT * FROM paciente WHERE cpf = '$cpf'";
    $dados = $pdo->query($sqlPaciente)->fetch(PDO::FETCH_ASSOC);
    $titulo = "Área do Paciente";
}
// Se médico estiver logado
elseif (isset($_SESSION['crm'])) {
    $crm = $_SESSION['crm'];
    $sql = "SELECT * FROM consulta WHERE crm_medico = '$crm'";
    $result = $pdo->query($sql);

    $sqlMedico = "SELECT * FROM medico WHERE crm = '$crm'";
    $dados = $pdo->query($sqlMedico)->fetch(PDO::FETCH_ASSOC);
    $titulo = "Área do Médico";
}


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <title>Meus Dados</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estiloNovo.css" type="text/css">
    <style>
        html, body {
            height: auto !important;
            overflow: auto !important;
            position: relative !important;
            overflow-x: hidden !important; /* Previne scroll horizontal indesejado */
        }
  
        /* Se houver algum container específico com problema de scroll */
        .container, .main-content, .page-content {
            height: auto !important;
            overflow: visible !important;
            min-height: 100vh;
        }
        .card-consultas .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            color: white;
        }

        .card-consultas .badge-confirmado {
            background-color: #28a745;
        }

        .card-consultas .badge-pendente {
            background-color: #ed8936;
        }
    </style>



</head>

<body class="with-navbar">
    <!-- Mova a navbar para fora do main e para o topo do body -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="Home.php">
                <img src="imagens/logo.png" alt="" height="50" class="d-inline-block align-top">
            </a>
            <a href="logout.php" class="botao-logout ms-auto" title="Sair">
                <span class="material-icons" style="color: white;">logout</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="pagAgendamento.php">Agendar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="meusDados.php">Meus Dados</a>
                    </li>
                    <li class="nav-item">
                        <select class="login-select form-select" onchange="window.location.href=this.value" Login>
                            <option class="item-login" value="">Login</option>
                            <option class="item-login" value="loginMedico.php">Médico</option>
                            <option class="item-login" value="loginPaciente.php">Paciente</option>
                        </select>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container"></nav>
    <main class="container">
        <h1 class="titulo-principal"><?= $titulo ?></h1>
        <div class="grid-container">
            <!-- Card Dados -->
            <div class="card card-dados">
                <div class="perfil-container">
                    <div class="avatar">
                        <span><?= strtoupper(substr($dados['nome'], 0, 2)) ?></span>
                    </div>
                    <h2 class="titulo-card">Dados Pessoais</h2>
                    <button class="botao-editar" id="botao-editar">
                        <i class="fas fa-pencil-alt"></i> Editar
                    </button>
                </div>
                <div class="dados-lista">
                    <?php if (isset($dados['cpf'])): ?>
                        <div class="dado-item"><i class="fas fa-id-card icone"></i>
                            <div class="dado-conteudo">
                                <p class="dado-label">CPF:</p>
                                <p class="dado-valor"><?= $dados['cpf'] ?></p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="dado-item"><i class="fas fa-id-card icone"></i>
                            <div class="dado-conteudo">
                                <p class="dado-label">CRM:</p>
                                <p class="dado-valor"><?= $dados['crm'] ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="dado-item"><i class="fas fa-user icone"></i>
                        <div class="dado-conteudo">
                            <p class="dado-label">Nome:</p>
                            <p class="dado-valor"><?= $dados['nome'] ?></p>
                        </div>
                    </div>
                    <?php if (isset($dados['especialidade'])): ?>
                        <div class="dado-item"><i class="fas fa-stethoscope icone"></i>
                            <div class="dado-conteudo">
                                <p class="dado-label">Especialidade:</p>
                                <p class="dado-valor"><?= $dados['especialidade'] ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="dado-item dado-editavel"><i class="fas fa-envelope icone"></i>
                        <div class="dado-conteudo">
                            <p class="dado-label">E-mail:</p>
                            <p class="dado-valor dado-editavel-conteudo"><?= $dados['email'] ?></p>
                        </div>
                    </div>
                    <div class="dado-item dado-editavel"><i class="fas fa-phone icone"></i>
                        <div class="dado-conteudo">
                            <p class="dado-label">Telefone:</p>
                            <p class="dado-valor dado-editavel-conteudo"><?= $dados['telefone'] ?></p>
                        </div>
                    </div>
                    <?php if (isset($dados['endereco'])): ?>
                        <div class="dado-item dado-editavel"><i class="fas fa-map-marker-alt icone"></i>
                            <div class="dado-conteudo">
                                <p class="dado-label">Endereço:</p>
                                <p class="dado-valor dado-editavel-conteudo"><?= $dados['endereco'] ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($dados['convenio'])): ?>
                        <div class="dado-item dado-editavel"><i class="fas fa-heartbeat icone"></i>
                            <div class="dado-conteudo">
                                <p class="dado-label">Convênio:</p>
                                <p class="dado-valor dado-editavel-conteudo"><?= $dados['convenio'] ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Card Consultas -->
            <div class="card card-consultas">
                <h2 class="titulo-card">Consultas</h2>
                <div class="consultas-lista">
                    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)):
                        if (isset($_SESSION['cpf'])) {
                            $sqlMed = "SELECT nome, especialidade FROM medico WHERE crm = " . $row['crm_medico'];
                            $info = $pdo->query($sqlMed)->fetch(PDO::FETCH_ASSOC);
                        } else {
                            $sqlPac = "SELECT nome FROM paciente WHERE cpf = " . $row['cpf_paciente'];
                            $info = $pdo->query($sqlPac)->fetch(PDO::FETCH_ASSOC);
                        }
                        ?>
                        <div class="consulta-item">
                            <div class="consulta-info">
                                <h3 class="consulta-especialidade"><?= $info['especialidade'] ?? '' ?></h3>
                                <p class="consulta-medico"><?= $info['nome'] ?></p>
                                <div class="consulta-detalhes">
                                    <div class="consulta-data"><i class="fas fa-calendar-alt icone-pequeno"></i><span
                                            class="dado-valor"><?= $row['data_hora'] ?></span></div>
                                </div>
                            </div>
                            <div class="consulta-acoes">
                                <?php
                                $badgeClass = '';
                                if ($row['status'] === 'Confirmado') {
                                    $badgeClass = 'badge-confirmado';
                                } elseif ($row['status'] === 'Pendente') {
                                    $badgeClass = 'badge-pendente';
                                }
                                ?>
                                <span class="badge <?= $badgeClass ?>">
                                    <?= $row['status'] ?>
                                </span>

                                <?php if (isset($_SESSION['crm']) && $row['status'] === 'Pendente'): ?>
                                    <a href="confirmarConsulta.php?id=<?= $row['id_consulta'] ?>"
                                        class="botao botao-confirmar">Confirmar</a>
                                <?php endif; ?>

                                <a href="deletar_consulta.php?id_consulta=<?= $row['id_consulta'] ?>"
                                    class="botao botao-deletar"
                                    onclick="return confirm('Tem certeza que deseja cancelar esta consulta?');">
                                    <i class="fas fa-trash-alt"></i> Cancelar
                                </a>
                            </div>


                        </div>
                    <?php endwhile; ?>
                </div>

                <?php if (isset($_SESSION['cpf'])): ?>
                    <a class="botao botao-full" href="pagAgendamento.php">Agendar Nova Consulta</a>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('botao-editar').addEventListener('click', function () {
            const campos = document.querySelectorAll('.dado-editavel-conteudo');
            const editando = this.classList.toggle('editando-ativo');
            if (editando) {
                this.innerHTML = '<i class="fas fa-save"></i> Salvar';
                campos.forEach(campo => campo.setAttribute('contenteditable', 'true'));
            } else {
                this.innerHTML = '<i class="fas fa-pencil-alt"></i> Editar';
                campos.forEach(campo => campo.setAttribute('contenteditable', 'false'));
                alert("Alterações salvas (simuladas)");
                // Aqui você pode enviar via AJAX
            }
        });
    </script>

    
</body>

</html>