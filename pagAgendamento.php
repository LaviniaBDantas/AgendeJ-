<?php
    $servername = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "agendeja";

    $conexao = new mysqli($servername, $usuario, $senha, $banco);
    if ($conexao->connect_error) {
        die("Erro de conexão: ". $conexao->connect_error);
    }

    // Processar agendamento completo
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['data_hora']) && isset($_POST['medico'])) {
        $nome_medico = $_POST['medico'];
        $data_hora = $_POST['data_hora'];
        
        $resultado = $conexao->query("SELECT crm FROM medico WHERE nome='$nome_medico'");
        
        if ($resultado && $resultado->num_rows > 0) {
            $linha = $resultado->fetch_assoc();
            $crm_medico = $linha['crm'];
            
            // Inserir consulta (simulando com paciente 1)
            $sql = "INSERT INTO consulta(crm_medico, cpf_paciente, data_hora) 
                    VALUES ('$crm_medico', 1, '$data_hora')";
            
            if ($conexao->query($sql) === TRUE) {
                header("Location: Usuario.php");
                exit;
            } else {
                $erro = "Erro ao cadastrar consulta: " . $conexao->error;
            }
         }
    }

    $especialidades = $conexao->query("SELECT especialidade FROM medico GROUP BY especialidade");
    if (!$especialidades) {
        die("Erro na consulta: " . $conexao->error);
    }

    // Buscar médicos se especialidade foi selecionada
    $medicos = array();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['especialidade'])) {
        $especialidade = $_POST['especialidade'];
        $result_medicos = $conexao->query("SELECT nome FROM medico WHERE especialidade = '$especialidade'");
        
        if ($result_medicos) {
            while ($row = $result_medicos->fetch_assoc()) {
                $medicos[] = $row;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos - Agende Já</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estiloNovo.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Navbar (mantido igual) -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <!-- ... conteúdo existente ... -->
    </nav>

    <!-- Form Section -->
    <section class="form-section">
        <div class="login-container">
            <h1>Agendamento</h1>
            
            <?php if (isset($erro)): ?>
                <div class="alert alert-danger"><?= $erro ?></div>
            <?php endif; ?>
            
            <form action="" method="POST">
                <!-- Especialidade -->
                <div class="mb-3">
                    <select class="form-select" id="especialidade" name="especialidade" required onchange="this.form.submit()">
                        <option value="" disabled selected>Selecione uma especialidade</option>
                        <?php while ($row = $especialidades->fetch_assoc()): ?>
                            <option value="<?= $row['especialidade'] ?>" 
                                <?= ($_POST['especialidade'] ?? '') == $row['especialidade'] ? 'selected' : '' ?>>
                                <?= $row['especialidade'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Médico -->
                <div class="mb-3">
                    <select class="form-select" id="medico" name="medico" required>
                        <option value="" disabled selected>Selecione um médico</option>
                        <?php foreach ($medicos as $medico): ?>
                            <option value="<?= $medico['nome'] ?>"><?= $medico['nome'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Data e Hora -->
                <div class="mb-3">
                    <input type="datetime-local" class="form-control" id="data_hora" name="data_hora" required>
                </div>

                <!-- Botão de Agendar -->
                <button type="submit" class="botao">Agendar Consulta</button>
            </form>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>