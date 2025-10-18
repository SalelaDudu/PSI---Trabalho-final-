<?php
require_once 'conexao.php';

$id_nacionalidade = $_GET['id'];

try {
    $sql = "DELETE FROM Nacionalidades WHERE id_Nacionalidades = '$id_nacionalidade'";
    $conn->query($sql);
    
    header('Location: /frontend/nacionalidades.php');
    exit();

} catch (Exception $error) {
    echo 'Ocorreu um erro ao deletar a nacionalidade. Ela pode estar em uso.<br><br>' . $error->getMessage();
}

$conn->close();
?>