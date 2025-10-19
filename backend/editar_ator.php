<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_ator = intval($_POST['id_ator']);
    $nome = $conn->real_escape_string($_POST['nome']);
    $sobrenome = $conn->real_escape_string($_POST['sobrenome']);

    $sql = "UPDATE Atores 
            SET nome = '$nome', sobrenome = '$sobrenome'
            WHERE id_Atores = $id_ator";

    if ($conn->query($sql)) {
        header('Location: /frontend/atores.php?msg=sucesso');
        exit;
    } else {
        echo "Erro ao atualizar ator: " . $conn->error;
    }
}

$conn->close();
?>
