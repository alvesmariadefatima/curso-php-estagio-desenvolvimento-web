<?php
function limpar_formatacao($str) {
    return preg_replace("/[^0-9]/", "", $str);
}

$erro = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['data_nascimento'];

    if (empty($nome)) {
        $erro .= "Preencha o nome<br>";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro .= "Preencha o email<br>";
    }

    if (empty($nascimento)) {
        $erro .= "A data de nascimento deve seguir o padrão dia/mês/ano<br>";
    } else {
        $pedacos = explode('/', $nascimento);
        if (count($pedacos) == 3) {
            $nascimento = implode('-', array_reverse($pedacos));
        }
    }

    if (empty($telefone)) {
        $erro .= "Preencha o telefone<br>";
    } else {
        $telefone = limpar_formatacao($telefone);
        if (strlen($telefone) != 11) {
            $erro .= "O telefone deve ser preenchido no padrão (11) 98888-8888<br>";
        }
    }

    if (empty($erro)) {
        include('conexao.php');

        $sql = "INSERT INTO clientes(nome, email, telefone, nascimento, data_cadastro)
                VALUES ('$nome', '$email', '$telefone', '$nascimento', NOW())";

        if ($mysqli->query($sql)) {
            $mensagem_sucesso = "Cliente cadastrado com sucesso!";
            // Reset form values
            $_POST = array();
        } else {
            $erro = "Erro ao registrar o cliente: " . $mysqli->error;
        }

        $mysqli->close();
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
    <form method="POST">
        <?php if (!empty($erro)) { ?>
            <p><b>ERRO: <?php echo $erro; ?></b></p>
        <?php } ?>

        <?php if (!empty($mensagem_sucesso)) { ?>
            <h2><?php echo $mensagem_sucesso; ?></h2>
        <?php } ?>

        <a href="clientes.php">Voltar para a lista</a>
        <h1>Formulário de Cadastro</h1>

        <p>
            <label>Nome: </label>
            <input value="<?php if(isset($_POST['nome'])) echo $_POST['nome'] ?>" type="text" name="nome"><br>
        </p>

        <p>
            <label>E-mail: </label>
            <input value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>" type="text" name="email"><br>
        </p>

        <p>
            <label>Telefone: </label>
            <input value="<?php if(isset($_POST['telefone'])) echo $_POST['telefone'] ?>" placeholder="(11) 98888-8888" type="text" name="telefone"><br>
        </p>

        <p>
            <label>Data de Nascimento: </label>
            <input value="<?php if(isset($_POST['data_nascimento'])) echo $_POST['data_nascimento'] ?>" type="text" name="data_nascimento">
        </p>

        <button type="submit">Salvar Cliente</button>
    </form>
</body>
</html>