<?php
$server = "localhost";
$lojaDb = "root";
$passDb = "";
$database = "loja";
$connect = mysqli_connect($server, $lojaDb, $passDb, $database);

if (!$connect) {
    die("Erro na conexão: " . mysqli_connect_error());
}

function insertUser($connect){
    if(isset($_POST['cadastro'])){
        $nome = mysqli_real_escape_string($connect, $_POST['inputNome']);
        $alt = mysqli_real_escape_string($connect, $_POST['inputAlt']);
        $nasc = mysqli_real_escape_string($connect, $_POST['inputNasc']);
        $cidade = mysqli_real_escape_string($connect, $_POST['inputCid']);
        
        if(!empty($nome) && !empty($alt) && !empty($nasc) && !empty($cidade)){
            $alt = $alt / 100;
            $query = "INSERT INTO clientes(nome, altura, nascimento, cidade_id) VALUES ('$nome', '$alt', '$nasc', '$cidade')";
            $execute = mysqli_query($connect, $query);
            if($execute){
                echo "Usuário inserido com sucesso";
            } else {
                echo "Erro ao inserir dados: " . mysqli_error($connect);
            }
        } else {
            echo "Preencha todos os dados corretamente. Dados preenchidos -->";
            echo "Nome: " . $nome . " | Altura: " . $alt . " | Nascimento: " . $nasc . " | Cidade: " . $cidade;
        }
        voltar();
    }
}

function insertProd($connect){
    if(isset($_POST['cadastroProd'])){
        $nome = mysqli_real_escape_string($connect, $_POST['inputNome']);
        $preco = mysqli_real_escape_string($connect, $_POST['inputPreco']);
        $quant = mysqli_real_escape_string($connect, $_POST['inputQuant']);
        $categoria = mysqli_real_escape_string($connect, $_POST['inputCat']);
        
        if(!empty($nome) && !empty($preco) && !empty($quant) && !empty($categoria)){
            $query = "INSERT INTO produtos(nome, preco, quantidade, categoria_id) VALUES ('$nome', '$preco', '$quant', '$categoria')";
            $execute = mysqli_query($connect, $query);
            if($execute){
                echo "Produto inserido com sucesso";
            } else {
                echo "Erro ao inserir dados: " . mysqli_error($connect);
            }
        } else {
            echo "Preencha todos os dados corretamente. Dados preenchidos -->";
            echo "Nome: " . $nome . " | Preço: " . $preco . " | Quantidade: " . $quant . " | Categoria: " . $categoria;
        }
        voltar();
    }
}

function atualizarProd($connect){
    if(isset($_POST['atlProd'])){ 
        $id = mysqli_real_escape_string($connect, $_POST['inputId']);
        $nome = mysqli_real_escape_string($connect, $_POST['inputNome']);
        $preco = mysqli_real_escape_string($connect, $_POST['inputPreco']);
        $quant = mysqli_real_escape_string($connect, $_POST['inputQuant']);
        
        if(!empty($nome) && !empty($preco) && !empty($quant)){
            $query = "UPDATE produtos SET nome='$nome', preco='$preco', quantidade='$quant' WHERE id='$id'";
            $execute = mysqli_query($connect, $query);
            if($execute){
                echo "Produto atualizado com sucesso";
            } else {
                echo "Erro ao atualizar dados: " . mysqli_error($connect);
            }
        } else {
            echo "Preencha todos os dados corretamente. Dados preenchidos -->";
            echo "Nome: " . $nome . " | Preço: " . $preco . " | Quantidade: " . $quant . " | ID: " . $id;
        }
        voltar();
    }
}

function insertCat($connect){
    if(isset($_POST['cadastroCat'])){
        $nome = mysqli_real_escape_string($connect, $_POST['inputNome']);
        
        if(!empty($nome)){
            $query = "INSERT INTO categorias(nome) VALUES ('$nome')";
            $execute = mysqli_query($connect, $query);
            if($execute){
                echo "Categoria inserida com sucesso";
            } else {
                echo "Erro ao inserir dados: " . mysqli_error($connect);
            }
        } else {
            echo "Preencha todos os dados corretamente. Dados preenchidos -->";
            echo "Nome: " . $nome;
        }
        voltar();
    }
}

function deleteProd($connect){
    if(isset($_POST['removeProd'])){
        $id = mysqli_real_escape_string($connect, $_POST['inputProd']);
        if(!empty($id)){
            $query = "DELETE FROM produtos WHERE id='$id'";
            $execute = mysqli_query($connect, $query);
            if($execute){
                echo "Produto removido com sucesso";
            } else {
                echo "Erro ao remover dados: " . mysqli_error($connect);
            }
        } else {
            echo "Preencha todos os dados corretamente. Dados preenchidos -->";
            echo "ID: " . $id;
        }
    }
}

function cadastrarPed($connect, $cliID) {
    if(isset($_POST['fazerPedido'])) {
        $horario = mysqli_real_escape_string($connect, $_POST['inputHora']);
        $endereco = mysqli_real_escape_string($connect, $_POST['inputEnd']);
        $prodID = mysqli_real_escape_string($connect, $_POST['inputProd']);
        $quant = mysqli_real_escape_string($connect, $_POST['inputQuant']);

        if(!empty($horario) && !empty($endereco) && !empty($cliID) && !empty($prodID)) {
            // Inserção do pedido na tabela pedidos
            $query = "INSERT INTO pedidos(horario, endereco, cliente_id) VALUES ('$horario', '$endereco', '$cliID')";
            $execute = mysqli_query($connect, $query);

            if($execute) {
                $pedido_id = mysqli_insert_id($connect); // Obtém o ID do pedido inserido

                // Inserção dos produtos no pedido na tabela pedidos_produtos
                $query_produtos = "INSERT INTO pedidos_produtos(pedido_id, produto_id, quantidade) VALUES ('$pedido_id', '$prodID', '$quant')";
                $execute_produtos = mysqli_query($connect, $query_produtos);
                
                if($execute_produtos) {
                    echo "Pedido realizado com sucesso";
                } else {
                    echo "Erro ao inserir produtos no pedido: " . mysqli_error($connect);
                }
            } else {
                echo "Erro ao inserir dados do pedido: " . mysqli_error($connect);
            }
        } else {
            echo "Preencha todos os dados corretamente.";
        }
        voltar();
    }
}


function selectDados($connect, $tabela, $where = "1", $what = "*"){
    $query = "SELECT $what FROM $tabela WHERE $where";
    $execute = mysqli_query($connect, $query);
    if($execute){
        $result = mysqli_fetch_all($execute, MYSQLI_ASSOC);
        return $result;
    } else {
        echo "Erro na consulta: " . mysqli_error($connect);
        return [];
    }
}

function login($connect){
    if(isset($_POST['entrar'])){
        $name = mysqli_real_escape_string($connect, $_POST['inputNome']);
        $id = mysqli_real_escape_string($connect, $_POST['inputId']);
        
        $clientes = selectDados($connect, "clientes");
        $chave = false;
        
        foreach($clientes as $c){
            if($c['nome'] == $name && $c['id'] == $id){
                if(isset($_SESSION['nome']) && $_SESSION['nome'] == $name && $_SESSION['id'] == $id){
                    echo "O usuário já está conectado";
                } else {
                    $_SESSION['nome'] = $name;
                    $_SESSION['id'] = $id;
                    echo "Usuário mudado com sucesso";
                    criarPagina($connect, $name, $id); 
                }
                $chave = true;
                break;
            }
        }
        
        if(!$chave){
            echo 'Nome de usuário ou ID inválido';
            voltar();
        }
    }
}


function criarPagina($connect, $n, $id){
    if($n != 'admin'){
        header("location:pgClient.php?n=" . urlencode($n) . "&id=" . urlencode($id));
        exit;
    } else {
        header("location:pgAdmin.php?n=" . urlencode($n));
        exit;
    }
}


function voltar(){
    ?>
    <br><br>
    <a href="index.php">Voltar</a>
    <?php
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_GET['login'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['inputNome'];
        $id = $_POST['inputId'];

        if (!empty($nome) && !empty($id)) {
            // Verifica se já existe uma sessão ativa para este usuário
            if (isset($_SESSION['nome']) && $_SESSION['nome'] == $nome && $_SESSION['id'] == $id) {
                echo "O usuário já está conectado";
                voltar();
            } else {
                // Realiza a consulta no banco de dados para verificar o login
                $query = "SELECT * FROM clientes WHERE nome = ? AND id = ?";
                $stmt = $connect->prepare($query);
                $stmt->bind_param("si", $nome, $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $_SESSION['nome'] = $nome;
                    $_SESSION['id'] = $id;
                    echo "Usuário mudado com sucesso!";
                } else {
                    echo "Nome ou ID incorretos.";
                }
                voltar();
            }
        } else {
            echo "Preencha todos os campos.";
            voltar();
        }
    }
}






if (isset($_REQUEST['cadastrar']) && $connect){
    insertUser($connect);
} elseif (isset($_REQUEST['login']) && $connect){
    login($connect);
} elseif (isset($_REQUEST['cadProd']) && $connect){
    insertProd($connect);
} elseif (isset($_REQUEST['cadPed']) && $connect){
    $cliID = $_GET['id'];
    cadastrarPed($connect, $cliID);
} elseif (isset($_REQUEST['atProd']) && $connect){
    atualizarProd($connect);
} elseif (isset($_REQUEST['cadCat']) && $connect){
    insertCat($connect);
} elseif (isset($_REQUEST['remProd']) && $connect){
    deleteProd($connect);
}

?>
