<?php
require_once 'conexao.php';

$id_categoria = $_GET['id'];

try {
    $sql = "DELETE FROM Categorias WHERE id_Categorias = '$id_categoria'";
    $conn->query($sql);
    
    header('Location: /frontend/categorias.php');
    exit();

} catch (Exception $error) {
    echo 'Ocorreu um erro ao deletar a categoria. Ela pode estar em uso por um filme.<br><br>' . $error->getMessage();
}

$conn->close();
?>