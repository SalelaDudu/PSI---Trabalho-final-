<?php
error_reporting(0);
$conn = new mysqli("localhost","root","root","PSI");

if($conn->connect_errno){
    echo "Erro na ao conectar ao banco: ".$conn->connect_errno. " - ". $conn->connect_error;

}
$conn->set_charset('utf8mb4');