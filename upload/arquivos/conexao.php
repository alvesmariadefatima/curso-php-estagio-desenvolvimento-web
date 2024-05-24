<?php
//Conexão ao banco de dados

$hostname = "localhost";
$bancodedados = "upload";
$usuario = "root";
$senha = "";

$mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);
if ($mysqli->connect_errno){
    echo"Falha na conexão com o banco de dados: (" . $mysqli->connect_errno . ") " . $mysqli -> connect_error;
}
else {
  // echo"conectado!";
}
?>