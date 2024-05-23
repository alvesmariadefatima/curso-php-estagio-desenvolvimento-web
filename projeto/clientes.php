<?php
include('conexao.php');

$sql_clientes = "SELECT * FROM clientes";
$query_clientes = $mysqli->query($sql_clientes) or die($mysqli->error);
$num_clientes = $query_clientes->num_rows;

// Função para formatar o telefone
function formatar_telefone($telefone) {
    $ddd = substr($telefone, 0, 2);
    $parte1 = substr($telefone, 2, 5);
    $parte2 = substr($telefone, 7);
    return "($ddd) $parte1-$parte2";
}

// Função para formatar a data
function formatar_data($data) {
    if (!empty($data) && $data != '0000-00-00') {
        return date("d/m/Y", strtotime($data));
    }
    return 'Não Informada';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
</head>
<body>
    <h1>Lista de Clientes</h1>
    <p>Estes são os clientes cadastrados no seu sistema: </p>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Nascimento</th>
                <th>Data de Cadastro</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if($num_clientes == 0) { ?>
                <tr>
                    <td colspan="7">Nenhum cliente foi cadastrado</td>
                </tr>
            <?php 
            } else { 
                while($cliente = $query_clientes->fetch_assoc()) {
                    $telefone = "Não informado";
                    if(!empty($cliente['telefone'])) {
                        $telefone = formatar_telefone($cliente['telefone']);
                    }

                    $data_nascimento = formatar_data($cliente['nascimento']);
                    $data_cadastro = date("d/m/Y H:i", strtotime($cliente['data_cadastro']));
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($cliente['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($cliente['nome'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($cliente['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($telefone, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($data_nascimento, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($data_cadastro, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <a href="editar_cliente.php?id=<?php echo $cliente['id']; ?>">Editar</a>
                        <a href="deletar_cliente.php?id=<?php echo $cliente['id']; ?>">Deletar</a>
                    </td>
                </tr>
            <?php 
                }
            } 
            ?>
        </tbody>
    </table>
</body>
</html>
