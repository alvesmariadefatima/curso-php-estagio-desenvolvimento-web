<?php
include('conexao.php');

if(isset($_GET['deletar'])) {
    $path = $_GET['deletar'];
    $sql_query = $mysqli->query("SELECT id FROM arquivos WHERE path='$path'");
    if($sql_query->num_rows > 0) {
        $row = $sql_query->fetch_assoc();
        $id = $row['id'];

        // Excluir o registro do banco de dados
        $delete_query = $mysqli->query("DELETE FROM arquivos WHERE id='$id'");
        if($delete_query) {
            // Excluir o arquivo do servidor se o registro do banco de dados for excluído com sucesso
            if(unlink($path)) {
                echo "<p>Arquivo excluído com sucesso!</p>";
            } else {
                echo "<p>Falha ao excluir o arquivo!</p>";
            }
        } else {
            echo "<p>Falha ao excluir o registro do banco de dados!</p>";
        }
    }
}

if(isset($_FILES['arquivo']));

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['arquivo'])) {
    $arquivo = $_FILES['arquivo'];

    // Verificar se houve erro no upload
    if ($arquivo['error']) {
        die("Falha ao enviar um ou mais arquivos");
    }

    // Verificar o tamanho do arquivo (máx 2MB)
    if ($arquivo['size'] > 2097152) {
        die("Arquivo muito grande! Máx: 2MB");
    }

    $pasta = "arquivos/";

    // Criar a pasta se ela não existir
    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $nomeDoArquivo = $arquivo['name'];
    $novoNomeDoArquivo = uniqid();
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
    
    // Verificar a extensão do arquivo
    if ($extensao != "jpg" && $extensao != "png") {
        die("Tipo de arquivo não aceito");
    }

    // Caminho completo do novo arquivo
    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;

    // Mover o arquivo para a pasta desejada
    if (move_uploaded_file($arquivo["tmp_name"], $path)) {
        $mysqli->query("INSERT INTO arquivos (nome, path) VALUES('$nomeDoArquivo', '$path')") or die($mysqli->error);
        echo "<p>Todos os arquivos foram enviados com sucesso!!!</p>";
    } else {
        echo "<p>Falha ao enviar um ou mais arquivos</p>";
    }
}

// Consulta para exibir os arquivos
$sql_query = $mysqli->query("SELECT * FROM arquivos") or die($mysqli->error);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Arquivos</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data" action="">
        <p><label>Selecione o arquivo</label>
        <input multiple name="arquivo" type="file"></p>
        <button name="upload" type="submit">Enviar arquivo</button>
    </form>

    <h1>Lista de Arquivos</h1>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Preview</th>
                <th>Arquivo</th>
                <th>Data de Envio</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
           <?php
                while($arquivo = $sql_query->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><img height='50' src='" . $arquivo['path'] . "'></td>";
                    echo "<td><a href='".$arquivo['path']."' target='_blank'>".$arquivo['nome']."</a></td>";
                    echo "<td>".$arquivo['data_upload']."</td>"; // Supondo que existe uma coluna 'data_envio'
                    echo "<th><a href='index.php?deletar=" . $arquivo['path'] . "'>Deletar</a></th>";
                    echo "</tr>";
                }
            ?> 
        </tbody>
    </table>
</body>
</html>
