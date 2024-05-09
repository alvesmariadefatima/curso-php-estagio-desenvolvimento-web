<?php
$servidor = "localhost";
$usuario = "programador";
$pass = "senha";
$db = "upload";

$conexao = mysqli_connect($servidor, $usuario, $pass, $db);
if (!$conexao) {
    die("Houve um erro: " . mysqli_connect_error());
}