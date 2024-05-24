<?php
    if(isset($_POST['nome'])) {
        $venc = time() + (30 * 24 * 60 * 60); // 30 dias
        setcookie("nome", $_POST['nome'], $venc);
        header("Location: boasvindas.php");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aula sobre Cookies em PHP</title>
</head>
<body>
    <form method="POST" action="">
        <p>Qual é o seu nome? </p>
        <input type="text" name="nome">
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
