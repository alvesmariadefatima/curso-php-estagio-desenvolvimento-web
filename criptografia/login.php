<?php
include('conexao.php');
session_start(); // Inicie a sessão no início do script

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql_code = "SELECT * FROM senhas WHERE email = '$email' LIMIT 1";
    $sql_exec = $conexao->query($sql_code) or die($conexao->error);

    $usuario = $sql_exec->fetch_assoc();
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario['id']; // Defina a variável de sessão

        // Redirecione após definir a variável de sessão
        header("Location: index.php");
        exit; // Certifique-se de sair do script após o redirecionamento
    } else {
        echo "Falha ao logar! E-mail ou senha incorretos";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form method="POST" action="">
        <h1>Login</h1>
        <p>
            <label>E-mail: </label>
            <input type="text" name="email"><br>
        </p>

        <p>
            <label>Senha: </label>
            <input type="password" name="senha"><br>
        </p>
        <button type="submit">Logar</button>
    </form>
</body>

</html>