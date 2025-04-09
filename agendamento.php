<?php
    $servername = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "agendeja";

    $conexao = new mysqli($servername, $usuario, $senha,$banco);

    if ($conexao->connect_error){
        die("Erro de conexao! ");
        
    }

    if ($_SERVER["REQUEST_METHOD"]=="POST"){
        $nome_medico=$_POST['medico'];
        // $crm_medico	= $conexao->query("SELECT crm FROM medico WHERE nome='$nome_medico'");
        // if(!$crm_medico){
        //     echo "Medico não encontrado";
        // }

        $resultado = $conexao->query("SELECT crm FROM medico WHERE nome='$nome_medico'");
        if ($resultado && $resultado->num_rows > 0) {
            $linha = $resultado->fetch_assoc();
            $crm_medico = $linha['crm'];
        } else {
            
            echo "Médico não encontrado";
            exit;
        }

        // $cpf_paciente logado
        $data_hora = $_POST['data_hora'];
        //SIMULANDO COM PACIENTE 1
        $sql = "INSERT INTO consulta(crm_medico,cpf_paciente,data_hora) VALUES ('$crm_medico', 1,'$data_hora')";
        if ($conexao->query($sql)===TRUE) {
            echo "Consulta cadastrada";
            header("Location: Usuario.php");
        }else{
            echo "Erro ao cadastrar consulta";
        }
        
    }
?>