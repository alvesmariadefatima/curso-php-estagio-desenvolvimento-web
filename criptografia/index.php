<?php
    include('conexao.php');
    if(!isset($_SESSION)) {
        session_start();
    }

    if(!isset($_SESSION['usuario'])) {
        die("Você não está logado. <a href='login.php'>Clique aqui</a> para logar.");
    }

    $id = $_SESSION['usuario'];
    $sql_query = $conexao->query("SELECT * FROM senhas WHERE id = $id") or die($conexao->error);
    $susuario = $sql_query->fetch_assoc();

    /* if($susuario['nivel'] != 'admin') {
        die("Você não tem acesso a essa página.");
    }  */

    if(isset($_POST['email'], $_POST['senha'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Hash da senha antes de inserir no banco de dados
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Use declarações preparadas para evitar SQL Injection
        $stmt = $conexao->prepare("INSERT INTO senhas (email, senha) VALUES(?, ?)");
        $stmt->bind_param("ss", $email, $senha_hash);
        $stmt->execute();
        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuários</title>
</head>
<body>
    <p>Bem-vindo(a), <?php echo $susuario['nome']; ?></p>
    <h1>Cadastro de Usuários</h1>

    <form action="" method="POST">
        <p>
            <label>E-mail: </label>
            <input type="text" name="email">
        </p>

        <p>
            <label>Senha: </label>
            <input type="password" name="senha">
        </p>
        <button type="submit">Cadastrar Senha</button>
    </form>
    <a href="logout.php">Sair</a>
</body>
</html>