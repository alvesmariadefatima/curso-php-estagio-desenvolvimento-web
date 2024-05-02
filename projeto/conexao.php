<?php

$host = "localhost";
$db = "crud_clientes";
$user = "programador";
$pass = "senha";

$mysqll = new mysqli($host, $user, $pass, $db);

if($mysqll->connect_errno) {
    die("Falha na conexao com o banco de dados.");
}