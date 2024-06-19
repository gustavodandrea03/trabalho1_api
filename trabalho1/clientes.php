<?php
require_once "conexao.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

voltar();


if (!isset($_SESSION['nome']) || $_SESSION['nome'] == 'admin') {
    header("Location: index.php");
    exit();
}

$nome = $_SESSION['nome'];
$id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambiente do Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f0f0f0;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            border-bottom: 2px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="datetime-local"],
        input[type="number"],
        select {
            width: calc(100% - 12px);
            padding: 8px;
            margin-bottom: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: green;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }
        input[type="submit"]:hover {
            background-color: blue;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</p>
        <a href="logout.php">Sair</a>
        
        <h2>Pedidos Realizados</h2>
                
        <?php
        $pedidos = selectDados($connect, 'pedidos', "cliente_id = $id");
        if ($pedidos) {
            foreach ($pedidos as $pedido) {
                $query_produtos = "SELECT pp.produto_id, pp.quantidade, p.nome AS produto_nome 
                                    FROM pedidos_produtos pp
                                    JOIN produtos p ON pp.produto_id = p.id
                                    WHERE pp.pedido_id = {$pedido['id']}";
                $produtos_pedido = mysqli_query($connect, $query_produtos);
                
                if(mysqli_num_rows($produtos_pedido) > 0) {
                    echo "<hr>Pedido " . $pedido['id'] . " | Endereço: " . $pedido['endereco'] . " | Horário: " . $pedido['horario'];
                    echo "<br>Produtos:";
                    echo "<ul>";
                    while($produto = mysqli_fetch_assoc($produtos_pedido)) {
                        echo "<li>" . $produto['produto_nome'] . " - Quantidade: " . $produto['quantidade'] . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<hr>Pedido " . $pedido['id'] . " | Endereço: " . $pedido['endereco'] . " | Horário: " . $pedido['horario'];
                    echo "<br>Nenhum produto associado a este pedido.";
                }
            }
        } else {
            echo "<p>Você não tem pedidos realizados.</p>";
        }
        ?>

        <h2>Faça um novo pedido</h2>
        <form name="pedido" method="POST" action="conexao.php?cadPed&id=<?php echo $id ?>">
            <label for="endereco">Endereço: </label>
            <input type="text" name="inputEnd"><br><br>

            <label for="endereco">Data/Horário: </label>
            <input type="datetime-local" name="inputHora"><br><br>
            
            <label for="endereco">Quantidade: </label>
            <input type="number" name="inputQuant"><br><br>

            <label for="endereco">Produto: </label>
            <select name="inputProd">
                <?php
                $produtos_disponiveis = selectDados($connect, "produtos", "quantidade > 0");

                foreach ($produtos_disponiveis as $produto) {
                    echo "<option value='" . $produto['id'] . "'>" . $produto['nome'] . "</option>";
                }
                ?>
            </select>

            <input type="submit" name="fazerPedido" value="Enviar">
        </form>
    </div>
</body>
</html>
