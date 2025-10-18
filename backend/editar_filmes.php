<?php
require_once 'conexao.php';

$id_filme = $_POST['id_filme']; 
$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];
$ano = $_POST['ano'];
$classificacao = $_POST['classificacao'];
$id_categoria = $_POST['id_categoria'];
$id_idioma = $_POST['id_idioma'];
$id_nacionalidade = $_POST['id_nacionalidade'];

$nacionalidade_para_db;
if (empty($id_nacionalidade)) {
    $nacionalidade_para_db = "NULL";
} else {
    $nacionalidade_para_db = "'$id_nacionalidade'";
}

try {
    $sql_update_filme = "UPDATE Filmes SET
                            titulo = '$titulo',
                            descricao = '$descricao',
                            ano = '$ano',
                            classificacao = '$classificacao',
                            Categorias_idCategorias = '$id_categoria',
                            Nacionalidade_id_Nacionalidades = $nacionalidade_para_db
                        WHERE id_Filmes = '$id_filme'";
    
    $conn->query($sql_update_filme);

    $sql_delete_idioma = "DELETE FROM Filmes_has_idioma WHERE Filmes_id_Filmes = '$id_filme'";
    $conn->query($sql_delete_idioma);
    
    $sql_insert_idioma = "INSERT INTO Filmes_has_idioma (Filmes_id_Filmes, idiomas_id_idiomas) 
                          VALUES ('$id_filme', '$id_idioma')";
    $conn->query($sql_insert_idioma);

    header('Location: /frontend/filmes.php');
} catch (Exception $error) {
    echo 'Ocorreu um erro ao atualizar o filme: ' . $error->getMessage();
}
$conn->close();
?>