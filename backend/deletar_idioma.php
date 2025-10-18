<?php
require_once 'conexao.php';

$id_idioma = $_GET['id'];

try {
    $sql = "DELETE FROM Idiomas WHERE id_Idiomas = '$id_idioma'";
    $conn->query($sql);
    
    header('Location: /frontend/idiomas.php');
    exit();

} catch (Exception $error) {
    echo 'Ocorreu um erro ao deletar o idioma. Ele pode estar em uso por um filme.<br><br>' . $error->getMessage();
}

$conn->close();
?>