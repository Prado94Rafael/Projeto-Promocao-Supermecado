<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promoções</title>
</head>
<body>
    <a href="../menu.php"><button>Voltar ao Menu</button></a>
    <h2>Promoções</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
        <label for="estabelecimento">Escolha o Estabelecimento:</label><br>
        <select id="estabelecimento" name="estabelecimento">
            <option value="">Selecione o Estabelecimento</option>
            <?php
            // Estabelece a conexão com o banco de dados
            $conexao = new mysqli("localhost", "root", "", "produtos_de_supermercados");

            // Verifica a conexão
            if ($conexao->connect_error) {
                die("Conexão falhou: " . $conexao->connect_error);
            }

            // Consulta SQL para obter os estabelecimentos disponíveis
            $sql = "SELECT DISTINCT nome_fantasia FROM estabelecimentos";
            $resultado = $conexao->query($sql);

            // Verifica se há resultados
            if ($resultado->num_rows > 0) {
                // Exibe os estabelecimentos como opções no menu suspenso
                while ($row = $resultado->fetch_assoc()) {
                    echo "<option value='{$row['nome_fantasia']}'>{$row['nome_fantasia']}</option>";
                }
            }

            // Fecha a conexão com o banco de dados
            $conexao->close();
            ?>
        </select><br><br>
        
        <input type="submit" value="Mostrar Promoções">
    </form>

    <?php
    // Verifica se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['estabelecimento']) && !empty($_GET['estabelecimento'])) {
        $estabelecimento_escolhido = $_GET['estabelecimento'];

        // Estabelece novamente a conexão com o banco de dados
        $conexao = new mysqli("localhost", "root", "", "produtos_de_supermercados");

        // Verifica a conexão
        if ($conexao->connect_error) {
            die("Conexão falhou: " . $conexao->connect_error);
        }

        // Consulta SQL para obter os produtos com menor preço no estabelecimento escolhido
        $sql = "SELECT p.marca, p.nome_produto, pl.preco, p.imagem
                FROM produtos p
                INNER JOIN preco_produtos_lojas pl ON p.nome_produto = pl.nome_produto
                WHERE pl.preco = (
                    SELECT MIN(preco)
                    FROM preco_produtos_lojas
                    WHERE nome_produto = p.nome_produto
                    AND marca = p.marca
                )
                AND pl.nome_fantasia = '$estabelecimento_escolhido'";

        $resultado = $conexao->query($sql);

        // Verifica se há resultados
        if ($resultado->num_rows > 0) {
            // Exibe os produtos, preços e imagens
            echo "<h3>Produtos com menor preço que os concorrentes no $estabelecimento_escolhido:</h3>";
            echo "<ul>";
            while ($row = $resultado->fetch_assoc()) {
                echo "<li>{$row['marca']} - {$row['nome_produto']} - R$ {$row['preco']}</li>";
                // Verifica se o caminho da imagem está definido e não está vazio
                if (!empty($row['imagem'])) {
                    echo "<img src='{$row['imagem']}' alt='{$row['nome_produto']}' width='100' height='100'><br>";
                } else {
                    echo "<p>Imagem não disponível para este produto.</p>";
                }
            }
            echo "</ul>";
        } else {
            echo "<p>Não há promoções disponíveis para $estabelecimento_escolhido.</p>";
        }

        // Fecha a conexão com o banco de dados
        $conexao->close();
    }
    ?>
</body>
</html>
