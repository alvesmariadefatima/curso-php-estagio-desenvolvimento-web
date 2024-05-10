<?php
include('conexao.php');

$deu_certo = false; // Inicializa a variável $deu_certo

if(isset($_FILES) && count($_FILES) > 0) {
    function enviarArquivo($error, $size, $tmp_name, $name) {
        global $conexao, $deu_certo;

        if($error) {
            die("Falha ao enviar arquivo.");
        }

        $pasta = "arquivos/";

        if (!file_exists($pasta)) {
            mkdir($pasta, 0777, true);
        }

        $novoNomeDoArquivo = uniqid();
        $extensao = strtolower(pathinfo($name, PATHINFO_EXTENSION));

        if($extensao != "jpg" && $extensao != "png") {
            die("Tipo de arquivo não aceito");
        }

        $caminhoCompleto = $pasta . $novoNomeDoArquivo . "." . $extensao;

        $deu_certo = move_uploaded_file($tmp_name, $caminhoCompleto);

        if($deu_certo) {
            // Insira o caminho do arquivo no banco de dados
            $sql = "INSERT INTO arquivos (path, data_upload) VALUES ('$caminhoCompleto', NOW())";
            $conexao->query($sql) or die($conexao->error);
        } else {
            die("Falha ao mover o arquivo para o diretório de destino.");
        }
    }

    if(isset($_FILES['arquivo'])) {
        $arquivos = $_FILES['arquivo'];
        
        foreach($arquivos['name'] as $index => $nome) {
            enviarArquivo($arquivos['error'][$index], $arquivos['size'][$index], $arquivos['tmp_name'][$index], $nome);
        }
    }
}

$sql_query = $conexao->query("SELECT * FROM arquivos") or die($conexao->error);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de arquivos</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data" action="">
        <p><label for="">Selecione o arquivo</label>
            <input multiple name="arquivo[]" type="file"></p>
            <button name="upload" type="submit">Enviar arquivo</button>
    </form>

    <h1>Lista de Arquivos</h1>
    <table border="1" cellpadding="10">
        <thead>
            <th>Preview</th>
            <th>Arquivo</th>
            <th>Data de Envio</th>
        </thead>
        <tbody>
            <?php while($arquivo = $sql_query->fetch_assoc()) { ?>
                <tr>
                    <td><img height="50" src="<?php echo $arquivo['path'] ?>" alt=""></td>
                    <td><a target="_blank" href="<?php echo $arquivo['path'] ?>">Nome do Arquivo</a></td>
                    <td><?php echo date("d/m/Y H:i", strtotime($arquivo['data_upload'])) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php
    if(isset($_FILES['arquivo']) && $deu_certo) {
        echo "<p>Arquivo(s) enviado(s) com sucesso!</p>";
    } elseif(isset($_FILES['arquivo'])) {
        echo "Falha ao enviar arquivo";
    }
    ?>

</body>
</html>