<?php
require_once 'conexao.php';

$id_categoria = $_POST['id_categoria'];
$nome = $_POST['nome'];

try {
    $sql = "UPDATE Categorias SET categoria = '$nome' WHERE id_Categorias = '$id_categoria'";
    $conn->query($sql);
    
    header('Location: /frontend/categorias.php');
    exit();

} catch (Exception $error) {
    echo 'Ocorreu um erro ao atualizar a categoria: ' . $error->getMessage();
}

$conn->close();
?>