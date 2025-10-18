<?php
require_once 'conexao.php';

$id_nacionalidade = $_POST['id_nacionalidade'];
$nome = $_POST['nome'];

try {
    $sql = "UPDATE Nacionalidades SET nacionalidade = '$nome' WHERE id_Nacionalidades = '$id_nacionalidade'";
    $conn->query($sql);
    
    header('Location: /frontend/nacionalidades.php');
    exit();

} catch (Exception $error) {
    echo 'Ocorreu um erro ao atualizar a nacionalidade: ' . $error->getMessage();
}

$conn->close();
?>