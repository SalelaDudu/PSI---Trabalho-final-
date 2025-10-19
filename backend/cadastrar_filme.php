<?php 
require_once 'conexao.php';

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
    // Tenta inserir
    $sql_filme = "INSERT INTO Filmes 
                    (titulo, descricao, ano, classificacao, Categorias_idCategorias, Nacionalidade_id_Nacionalidades) 
                  VALUES 
                    ('$titulo', '$descricao', '$ano', '$classificacao', '$id_categoria', $nacionalidade_para_db)";

 
    $conn->query($sql_filme);

    // pega o id do ultimo filme adicionado btf
    $id_filme_novo = $conn->insert_id;

    // tenta meter o good pondo o filme no banco
    $sql_idioma = "INSERT INTO Filmes_has_idioma 
                    (Filmes_id_Filmes, idiomas_id_idiomas) 
                   VALUES 
                    ('$id_filme_novo', '$id_idioma')";
    
    $conn->query($sql_idioma);
    
    // se inserção == poggers -> página = mesma página só de meme
    header('Location: /frontend/filmes.php');
    exit();
} catch (Exception $error) {
    echo 'Ocorreu um erro: ' . $error->getMessage();
}

// da close nos falsos aliados
$conn->close(); 
?>