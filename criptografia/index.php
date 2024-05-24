<?php
include('conexao.php');

session_start();

// Verificar se o usuário está logado
if(!isset($_SESSION['usuario'])) {
    if(!isset($_POST['email']) || !isset($_POST['senha'])) {
        die("Você não está logado. <a href='login.php'>Clique aqui</a> para logar");
    }

    // Verificar credenciais de login
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql_query = $mysqli->prepare("SELECT * FROM senhas WHERE email = ?");
    $sql_query->bind_param("s", $email);
    $sql_query->execute();
    $result = $sql_query->get_result();
    $usuario = $result->fetch_assoc();

    if($usuario && password_verify($senha, $usuario['senha'])) {
        // Credenciais corretas, iniciar sessão
        $_SESSION['usuario'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome']; // Supondo que a coluna 'nome' existe na tabela 'senhas'
    } else {
        die("Credenciais inválidas. <a href='login.php'>Tente novamente</a>");
    }
} else {
    // Usuário já está logado, buscar informações
    $id = $_SESSION['usuario'];
    $sql_query = $mysqli->prepare("SELECT * FROM senhas WHERE id = ?");
    $sql_query->bind_param("i", $id);
    $sql_query->execute();
    $result = $sql_query->get_result();
    $usuario = $result->fetch_assoc();
}

// Inserir novos dados se o formulário de cadastro for enviado
if(isset($_POST['email']) && isset($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $insert_query = $mysqli->prepare("INSERT INTO senhas (email, senha) VALUES (?, ?)");
    $insert_query->bind_param("ss", $email, $senha);
    $insert_query->execute();
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
    <p>Bem-vindo(a), <?php echo htmlspecialchars($usuario['nome']); ?></p>
    <h1>Cadastro de Usuários</h1>

    <form method="POST" action="">
        <p>
            <label>E-mail: </label>
            <input type="email" name="email" required>
        </p>

        <p>
            <label>Senha: </label>
            <input type="password" name="senha" required>
        </p>
        <button type="submit">Cadastrar Senha</button>
    </form>
    <p><a href="logout.php">Sair</a></p>
</body>
</html>