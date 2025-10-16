<?php 
  require_once 'conexao.php';
  try{
    $idioma = $_REQUEST['nome'];
    $query = "INSERT INTO Idiomas(idioma) VALUES('$idioma')";
    $response = $conn->query($query);
    header('Location: /frontend/idiomas.php');
    }
    catch(Exception $error){
    echo''.$error;
  }
?>