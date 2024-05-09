<?php
include('conexao.php');

if (isset($_FILES['arquivo'])) {
    $arquivo = $_FILES['arquivo'];

    // Verifica se houve algum erro durante o envio do arquivo
    if ($arquivo['error']) {
        die("Falha ao enviar arquivo");
    }

    // Verifica se o tamanho do arquivo é maior que 2MB
    if ($arquivo['size'] > 2097152) {
        die("Arquivo muito grande! Max: 2MB");
    }

    // Pasta onde o arquivo será salvo
    $pasta = "arquivos/";

    // Nome original do arquivo
    $nomeDoArquivo = $arquivo['name'];

    // Gera um nome único para o arquivo
    $novoNomeDoArquivo = uniqid();

    // Obtém a extensão do arquivo
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

    // Verifica se a extensão do arquivo é suportada
    if ($extensao != "jpg" && $extensao != "png") {
        die("Tipo de arquivo não aceito");
    }

    // Define o caminho completo do arquivo
    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;

    // Move o arquivo temporário para o diretório de destino
    $deu_certo = move_uploaded_file($arquivo["tmp_name"], $path);

    if ($deu_certo) {
        // Obtém a data e hora atual
        $data_upload = date('Y-m-d H:i:s');

        // Insere os dados do arquivo no banco de dados
        $conexao->query("INSERT INTO arquivos('nome', 'path', 'data_upload') VALUES('$nomeDoArquivo', '$path', '$data_upload')") or die($conexao->error);

        // Exibe mensagem de sucesso
        echo "<p>Arquivo enviado com sucesso!</p>";
    } else {
        // Exibe mensagem de falha
        echo "<p>Falha ao enviar arquivo</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Arquivos</title>
</head>

<body>
    <form enctype="multipart/form-data" action="" method="POST">
        <p><label>Selecione o arquivo</label>
            <input name="arquivo" type="file">
        </p>

        <button name="upload" type="submit">Enviar arquivo</button>
    </form>
</body>
</html>