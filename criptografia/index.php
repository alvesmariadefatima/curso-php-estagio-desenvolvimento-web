<?php
include('conexao.php');
session_start();

if (!isset($_SESSION['usuario'])) {
    die("Você não está logado. <a href='login.php'>Clique aqui</a> para logar.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    // Não use password_hash() ao armazenar a senha no banco de dados
    $senha = $_POST['senha'];

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT); // Hash da senha

    $conexao->query("INSERT INTO senhas (email, senha) VALUES ('$email', '$senha_hash')");
}

$id = $_SESSION['usuario'];
$sql_query = $conexao->query("SELECT * FROM senhas WHERE id = $id") or die($conexao->error);
$usuario = $sql_query->fetch_assoc();

if ($usuario['nivel'] != 'admin') {
    die("Você não tem acesso a essa página.");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Senha</title>
</head>

<body>
    <p>Bem-vindo(a), <?php echo $usuario['nome']; ?></p>
    <h1>Cadastro de Usuários</h1>

    <form method="POST" action="">
        <p>
            <label>E-mail: </label>
            <input type="text" name="email">
        </p>

        <p>
            <label>Senha: </label>
            <input type="password" name="senha"> <!-- Use type="password" para senhas -->
        </p>
        <button type="submit">Cadastrar Senha</button>
    </form>
    <p><a href="logout.php">Sair</a></p>
</body>
</html>