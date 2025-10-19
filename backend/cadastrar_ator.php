<?php
require_once 'conexao.php';

$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$nascimento = $_POST['nascimento'];
$sexo = $_POST['sexo'];
$id_nacionalidade = $_POST['id_nacionalidade'];

try {
    // Tenta inserir
    $sql_ator = "INSERT INTO Atores 
                    (nome, sobrenome, nascimento, sexo, Nacionalidade_idNacionalidades) 
                  VALUES 
                    ('$nome', '$sobrenome', '$nascimento', '$sexo', '$id_nacionalidade')";

    $conn->query($sql_ator);

    // se inserção == poggers -> página = mesma página receba!
    header('Location: /frontend/atores.php');
    exit();
} catch (Exception $error) {
    echo 'Ocorreu um erro: ' . $error->getMessage();
}

$conn->close();     
?>