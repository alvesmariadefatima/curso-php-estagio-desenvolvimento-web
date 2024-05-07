<?php
    echo "<h1>Tipos e Formatos de Datas em PHP</h1>";
    
    // Mostrar a data atual em timestamp
    echo "<p>Data atual em timestamp: " . time() . "</p>";

    // Transformar timestamp em data atual
    echo "<p>Transformar timestamp em data atual: " . date("d/m/Y", time()) . "</p>";

    // Mostrar a data atual em timestamp
    echo "<p>Mostrar a data atual em timestamp: " . strtotime("2024-05-07") . "</p>";

    // Somar 10 dias em uma data
    $data = "2021-09-06";
    $nova_data = strtotime($data) + (86400*100);
    echo "<p>Somar 10 dias em uma data: " . date("d/m/Y", $nova_data) . "</p>";

    // Substrair 10 dias em uma data
    $data = "2021-09-06";
    $nova_data = strtotime($data) - (86400*10);
    echo "<p>Substrair 10 dias em uma data: " . date("d/m/Y", $nova_data) . "</p>";

    // Convertendo o timestamp pro banco de dados
    echo "<p>Convertendo o timestamp pro banco de dados: ". date("Y-m-d H:i:s", time()) . "</p>";

    // Descobrir dia da semana de uma data
    echo "<p>Descobrir dia da semana de uma data: " . date("D", $nova_data) . "</p>";
?>