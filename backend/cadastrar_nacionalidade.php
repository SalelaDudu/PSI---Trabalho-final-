<?php 
  require_once 'conexao.php';
  try{
    $nacionalidade = $_REQUEST['nome'];
    $query = "INSERT INTO Nacionalidades(nacionalidade) VALUES('$nacionalidade')";
    $response = $conn->query($query);
    header('Location: /frontend/nacionalidades.php');
    }
    catch(Exception $error){
    echo''.$error;
  }
?>