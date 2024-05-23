<?php
include('conexao.php');

// Função para formatar a data
function formatar_data($nascimento) {
    if (!empty($nascimento) && $nascimento != '0000-00-00') {
        return implode('/', array_reverse(explode('-', $nascimento)));
    }
    return '';
}

// Verificar se o ID do cliente foi passado
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Obter informações do cliente do banco de dados
    $sql_cliente = "SELECT * FROM clientes WHERE id = $id";
    $query_cliente = $mysqli->query($sql_cliente) or die($mysqli->error);
    $cliente = $query_cliente->fetch_assoc();

    if (!$cliente) {
        die("Cliente não encontrado.");
    }
} else {
    die("ID do cliente não especificado.");
}

// Processar o formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['data_nascimento'];

    $erro = '';

    if (empty($nome)) {
        $erro .= "Preencha o nome<br>";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro .= "Preencha o email corretamente<br>";
    }

    if (empty($nascimento)) {
        $erro .= "Preencha a data de nascimento<br>";
    } else {
        $pedacos = explode('/', $nascimento);
        if (count($pedacos) == 3) {
            $nascimento = implode('-', array_reverse($pedacos));
        } else {
            $erro .= "A data de nascimento deve seguir o padrão dia/mês/ano<br>";
        }
    }

    if (empty($telefone)) {
        $erro .= "Preencha o telefone<br>";
    } else {
        $telefone = preg_replace("/[^0-9]/", "", $telefone);
        if (strlen($telefone) != 11) {
            $erro .= "O telefone deve ser preenchido no padrão (11) 98888-8888<br>";
        }
    }

    if (empty($erro)) {
        $sql_update = "UPDATE clientes SET 
                        nome = '$nome', 
                        email = '$email', 
                        telefone = '$telefone', 
                        nascimento = '$nascimento' 
                        WHERE id = $id";

        if ($mysqli->query($sql_update)) {
            $mensagem_sucesso = "Cliente atualizado com sucesso!";
        } else {
            $erro = "Erro ao atualizar o cliente: " . $mysqli->error;
        }
    }
}

// Não feche a conexão com o banco de dados aqui para evitar o erro
// $mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
</head>
<body>
    <h1>Editar Cliente</h1>
    <form method="POST">
        <?php if (!empty($erro)) { ?>
            <p><b>ERRO: <?php echo $erro; ?></b></p>
        <?php } ?>

        <?php if (!empty($mensagem_sucesso)) { ?>
            <h2><?php echo $mensagem_sucesso; ?></h2>
        <?php } ?>

        <p>
            <label>Nome: </label>
            <input value="<?php echo htmlspecialchars($cliente['nome'], ENT_QUOTES, 'UTF-8'); ?>" type="text" name="nome"><br>
        </p>

        <p>
            <label>E-mail: </label>
            <input value="<?php echo htmlspecialchars($cliente['email'], ENT_QUOTES, 'UTF-8'); ?>" type="text" name="email"><br>
        </p>

        <p>
            <label>Telefone: </label>
            <input value="<?php echo htmlspecialchars($cliente['telefone'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="(11) 98888-8888" type="text" name="telefone"><br>
        </p>

        <p>
            <label>Data de Nascimento: </label>
            <input value="<?php echo htmlspecialchars(formatar_data($cliente['nascimento']), ENT_QUOTES, 'UTF-8'); ?>" type="text" name="data_nascimento">
        </p>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>

<?php
// Agora feche a conexão após todas as operações estarem completas
$mysqli->close();
?>