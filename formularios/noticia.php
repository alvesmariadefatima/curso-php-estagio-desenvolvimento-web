<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário com PHP</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h1>Formulário com PHP</h1>

        <p class="error">* Obrigatório</p>

        Nome: <input type="text" name="nome"><span class="error"> * </span><br><br>
        
        E-mail: <input type="text" name="email"><span class="error"> * </span><br><br>
        
        Website: <input type="text" name="website"><br><br>
        
        Comentário: <textarea name="comentario" cols="30" rows="3"></textarea>
        <br><br>
        
        Gênero: <input type="radio" value="feminino" name="genero"> Feminino
        <input type="radio" value="masculino" name="genero"> Masculino
        <input type="radio" value="outros" name="genero"> Outros
        <br><br>
        <button name="enviado" type="submit">Enviar</button>
        
        <h1>Dados enviados: </h1>

        <?php

        if(empty($_POST['nome']) || strlen($_POST['nome'] < 100)) {
            echo "<p class=\"error\">Preencha o campo nome</p>";
            die();
        }

        if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo "<p class=\"error\">Preencha o campo E-mail</p>";
            die();
        }

        if(!empty($_POST['website']) && filter_var('http://example.com', FILTER_VALIDATE_URL)) {
            echo "<p class=\"error\">Preencha corretamente o campo website</p>";
        }

            if(isset($_POST['enviado'])) {
                $genero = "Não selecionado";
    
                if(isset($_POST['genero'])) {
                    $genero = $_POST['genero'];

                    if($genero != "masculino" &&  $genero != "feminino" && $genero != "outros") {
                        echo "<p class=\"error\">Preencha corretamente o campo gênero</p>";
                        die();
                    }
                }
    
                echo "<p><b>Nome: </b>" . $_POST['nome'] . "</p>";
                echo "<p><b>E-mail: </b>" . $_POST['email'] . "</p>";
                echo "<p><b>Website: </b>" . $_POST['website'] . "</p>";
                echo "<p><b>Comentário: </b>" . $_POST['comentario'] . "</p>";
                echo "<p><b>Gênero: </b>" . $_POST['genero'] . "</p>";
            }
                echo $_POST['enviado'];    
        ?>
    </form>
</body>
</html>
