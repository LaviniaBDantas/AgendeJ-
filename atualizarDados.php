<?php
session_start();
include "db.php";

$response = ['status' => 'erro', 'mensagem' => 'Algo deu errado'];

try {
    if (isset($_SESSION['cpf'])) {
        $cpf = $_SESSION['cpf'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $endereco = $_POST['endereco'];
        $convenio = $_POST['convenio'];

        $sql = "UPDATE paciente SET email = ?, telefone = ?, endereco = ?, convenio = ? WHERE cpf = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email, $telefone, $endereco, $convenio, $cpf]);

        $response = ['status' => 'sucesso', 'mensagem' => 'Dados atualizados com sucesso'];

    } elseif (isset($_SESSION['crm'])) {
        $crm = $_SESSION['crm'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $endereco = $_POST['endereco'];

        $sql = "UPDATE medico SET email = ?, telefone = ?, endereco = ? WHERE crm = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email, $telefone, $endereco, $crm]);

        $response = ['status' => 'sucesso', 'mensagem' => 'Dados atualizados com sucesso'];
    }
} catch (Exception $e) {
    $response = ['status' => 'erro', 'mensagem' => $e->getMessage()];
}

echo json_encode($response);
?>
