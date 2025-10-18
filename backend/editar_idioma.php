<?php
require_once 'conexao.php';

$id_idioma = $_POST['id_idioma'];
$nome = $_POST['nome'];

try {
    $sql = "UPDATE Idiomas SET idioma = '$nome' WHERE id_Idiomas = '$id_idioma'";
    $conn->query($sql);
    
    header('Location: /frontend/idiomas.php');
    exit();

} catch (Exception $error) {
    echo 'Ocorreu um erro ao atualizar o idioma: ' . $error->getMessage();
}

$conn->close();
?>