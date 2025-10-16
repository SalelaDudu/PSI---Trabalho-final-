<?php 
require_once 'conexao.php'; // No seu código anterior você usou $conn, aqui estou usando $conexao como no nosso padrão

// Coleta os dados do formulário
$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];
$ano = $_POST['ano']; // O nome no formulário é 'ano_lancamento', no banco é 'ano'
$classificacao = $_POST['classificacao'];
$id_categoria = $_POST['id_categoria'];
$id_idioma = $_POST['id_idioma'];
$id_nacionalidade = $_POST['id_nacionalidade'];

// Lógica para tratar a nacionalidade opcional
$nacionalidade_para_db;
if (empty($id_nacionalidade)) {
    $nacionalidade_para_db = "NULL";
} else {
    // O nome da coluna no seu banco é 'Nacionalidade_id_Nacionalidades'
    $nacionalidade_para_db = "'$id_nacionalidade'";
}

try {
    // ETAPA 1: Inserir na tabela 'Filmes'
    // Usando os nomes das colunas do seu script de banco de dados
    $sql_filme = "INSERT INTO Filmes 
                    (titulo, descricao, ano, classificacao, Categorias_idCategorias, Nacionalidade_id_Nacionalidades) 
                  VALUES 
                    ('$titulo', '$descricao', '$ano', '$classificacao', '$id_categoria', $nacionalidade_para_db)";

    // Executa a primeira query
    $conn->query($sql_filme);

    // ETAPA 2: Pegar o ID do filme que acabamos de inserir
    $id_filme_novo = $conn->insert_id;

    // ETAPA 3: Inserir a associação na tabela 'Filmes_has_idioma'
    $sql_idioma = "INSERT INTO Filmes_has_idioma 
                    (Filmes_id_Filmes, idiomas_id_idiomas) 
                   VALUES 
                    ('$id_filme_novo', '$id_idioma')";
    
    // Executa a segunda query
    $conn->query($sql_idioma);
    
    // ETAPA 4: Redirecionar após o sucesso
    header('Location: /frontend/filmes.php');
    exit(); // Importante para parar a execução do script após o redirecionamento

} catch (Exception $error) {
    // Se qualquer uma das queries falhar, o erro será capturado aqui
    echo 'Ocorreu um erro: ' . $error->getMessage();
}

// Fecha a conexão
$conn->close();
?>