<?php
include('conexao.php'); // Inclui o arquivo de conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erro = false;
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];

    if (empty($nome)) {
        $erro = "Preencha o nome.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Preencha um e-mail válido.";
    }

    if (empty($nascimento)) {
        $erro = "Preencha a data de nascimento.";
    } else {
        // Verifica e corrige o formato da data de nascimento
        $tmp = explode("/", $nascimento);
        if (count($tmp) == 3) {
            $nascimento = implode("-", array_reverse($tmp));
        } else {
            $erro = "A data de nascimento deve seguir o padrão dia/mês/ano.";
        }
    }

    if (!empty($telefone)) {
        // Limpa o telefone removendo caracteres não numéricos
        function limpar_texto($str)
        {
            return preg_replace('/[^0-9]/', '', $str);
        }
        $telefone = limpar_texto($telefone);
        if (strlen($telefone) != 10) {
            $erro = "O telefone deve ser preenchido no padrão (11) 98765-4321.";
        }
    }

    if (!$erro) { // Se não houver erros, realiza a inserção no banco de dados
        $sql_code = "INSERT INTO clientes (nome, email, telefone, nascimento, data) 
                     VALUES('$nome', '$email', '$telefone', '$nascimento', NOW())";
        // echo "<p>Query SQL: $sql_code</p>"; // Descomente essa linha apenas para depuração
        $deu_certo = $mysqli->query($sql_code);

        if ($deu_certo) {
            echo "<p><b>Cliente cadastrado com sucesso!</b></p>";
            // Limpa os dados do formulário após a inserção bem-sucedida
            $_POST = array();
        } else {
            echo "<p><b>Ocorreu um erro ao cadastrar o cliente: " . $mysqli->error . "</b></p>";
        }
    } else {
        echo "<p><b>ERRO: $erro</b></p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
</head>

<body>
    <a href="clientes.php">Voltar para a lista</a>
    <form method="POST" action="">
        <p>
            <label>Nome: </label>
            <input value="<?php if (isset($_POST['nome'])) echo $_POST['nome']; ?>" name="nome" type="text">
        </p>

        <p>
            <label>E-mail: </label>
            <input value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" type="text" name="email">
        </p>

        <p>
            <label>Telefone: </label>
            <input value="<?php if (isset($_POST['telefone'])) echo $_POST['telefone']; ?>" placeholder="(11) 98765-4321" type="text" name="telefone">
        </p>

        <p>
            <label>Data de Nascimento: </label>
            <input value="<?php if (isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>" type="text" name="nascimento">
        </p>

        <p>
            <button type="submit">Salvar Cliente</button>
        </p>
    </form>
</body>

</html>