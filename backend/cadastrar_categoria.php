<?php 
  require_once 'conexao.php';
  try{
    $categoria = $_REQUEST['nome'];
    $query = "INSERT INTO Categorias(categoria) VALUES('$categoria')";
    $response = $conn->query($query);
    header('Location: /frontend/categorias.php');
    }
    catch(Exception $error){
    echo''.$error;
  }
?>