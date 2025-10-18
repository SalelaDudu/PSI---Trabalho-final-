<?php
require_once 'conexao.php';

$id_filme = $_GET['id'];

try {
    $sql_delete_idiomas = "DELETE FROM Filmes_has_idioma WHERE Filmes_id_Filmes = '$id_filme'";
    $conn->query($sql_delete_idiomas);

    $sql_delete_atores = "DELETE FROM Filmes_has_Atores WHERE Filmes_id_Filmes = '$id_filme'";
    $conn->query($sql_delete_atores);

    $sql_delete_filme = "DELETE FROM Filmes WHERE id_Filmes = '$id_filme'";
    $conn->query($sql_delete_filme);

    header('Location: /frontend/filmes.php');
    exit();

} catch (Exception $error) {
    echo 'Ocorreu um erro ao excluir o filme: ' . $error->getMessage();
}

$conn->close();
?>