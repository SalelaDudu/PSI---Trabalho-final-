<?php
require_once 'conexao.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_ator = (int) $_GET['id']; // força a ser número inteiro

    try {
        $sql = "DELETE FROM Atores WHERE id_Atores = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_ator);
        $stmt->execute();

        // redireciona de volta
        header('Location: /frontend/atores.php');
        exit();

    } catch (Exception $error) {
        echo 'Ocorreu um erro ao deletar o ator.<br><br>' . $error->getMessage();
    }

    $stmt->close();
} else {
    echo "ID inválido.";
}

$conn->close();
?>
