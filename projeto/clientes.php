<?php
include("conexao.php");

$sql_clientes = "SELECT * FROM clientes";
$query_clientes = $mysqli->query($sql_clientes) or die($mysqli->error);
$num_clientes = $query_clientes->num_rows;
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
                <th>Data de Nascimento</th>
                <th>Data de Cadastro</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php if ($num_clientes == 0) { ?>
                <tr>
                    <td colspan="7">Nenhum cliente foi cadastrado.</td>
                </tr>
                <?php } else {
                while ($cliente = $query_clientes->fetch_assoc()) {

                    $telefone = "Não informado";
                    if (!empty($cliente['telefone'])) {
                        $ddd = substr($cliente['telefone'], 0, 2);
                        $parte1 = substr($cliente['telefone'], 2, 5);
                        $parte2 = substr($cliente['telefone'], 7);
                        $telefone = "($ddd) $parte1-$parte2";
                    }

                    $nascimento = "Não informado";
                    if (!empty($cliente['nascimento'])) {
                        $nascimento = date("d/m/Y", strtotime($cliente["nascimento"]));
                    }

                    $data_cadastro = date("d/m/y H:i", strtotime($cliente['data']));
                ?>
                    <tr>
                        <td><?php echo $cliente['id']; ?></td>
                        <td><?php echo $cliente['nome']; ?></td>
                        <td><?php echo $cliente['email']; ?></td>
                        <td><?php echo $telefone; ?></td>
                        <td><?php echo $nascimento; ?></td>
                        <td><?php echo $data_cadastro; ?></td>
                        <td>
                            <a href="editar_cliente.php?id=<?php echo $cliente['id']; ?>">Editar</a>
                            <a href="deletar_cliente.php?id=<?php echo $cliente['id']; ?>">Deletar</a>
                        </td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
</body>

</html>