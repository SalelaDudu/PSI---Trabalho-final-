<?php
require_once 'conexao.php';

$id_filme = $_POST['id_filme'] ?? null;
$id_ator  = $_POST['id_ator'] ?? null;

if ($id_filme && $id_ator) {
    $stmt = $conn->prepare("INSERT INTO filmes_has_atores (filmes_id_filmes, atores_id_atores) VALUES (?, ?)");
    $stmt->bind_param("ii", $id_filme, $id_ator);
    $stmt->execute();
    $stmt->close();

    header("Location: ../frontend/filmes.php?msg=ator_vinculado");
    exit;
} else {
    echo "Erro: id do filme ou ator não informado.";
}
$conn->close();
?>
