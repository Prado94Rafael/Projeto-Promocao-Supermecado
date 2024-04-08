<?php
// Verifique se o produto foi enviado via GET
if (isset($_GET['produto'])) {
    $produtoSelecionado = $_GET['produto'];

    // Conecte-se ao banco de dados
    $conexao = new mysqli("localhost", "root", "", "produtos_de_supermercados");

    // Verifique a conexão
    if ($conexao->connect_error) {
        die("Conexão falhou: " . $conexao->connect_error);
    }

    // Query para selecionar todas as marcas do produto selecionado
    $queryMarcas = "SELECT DISTINCT marca FROM produtos WHERE nome_produto = '$produtoSelecionado'";
    $resultadoMarcas = $conexao->query($queryMarcas);

    // Array para armazenar as marcas
    $marcas = array();

    // Loop através dos resultados e adicionar as marcas ao array
    if ($resultadoMarcas && $resultadoMarcas->num_rows > 0) {
        while ($linhaMarca = $resultadoMarcas->fetch_assoc()) {
            $marcas[] = $linhaMarca['marca'];
        }
    }

    // Fechar conexão
    $conexao->close();

    // Enviar as marcas como JSON
    echo json_encode($marcas);
}
?>
