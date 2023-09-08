<?php
require_once 'Pessoa.php';
$p = new Pessoa('localhost','banco','root','');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <?php
    //Verifica se existe algo no formulário e trata
    if(isset($_POST['nome']) && isset($_POST['dataNascimento'])){
        $nome = addslashes($_POST['nome']);
        $dataNascimento = addslashes($_POST['dataNascimento']);
    }
    
    
    if(empty($nome) || empty($dataNascimento)){
        echo "Preencha todo os campos!";
    }else{
        if($p->insere($nome,$dataNascimento)){
            echo "e-mail cadastrado";
        }else{
            echo "emai não foi cadastrado";
        }
    }
    ?>
    <section id="esquerda">
        <form action="#" method="post">
            <h1>Cadastrar Pessoa</h1>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome">
            <label for="dataNascimento">Data de Nascimento</label>
            <input type="date" name="dataNascimento" id="dataNascimento">
            <label for="submit">submit</label>
            <input type="submit" value="submit">
        </form>
    </section>
    <section id="direita">
        <table>
            <tr id="titulo">
                <td>Nome</td>
                <td>data de nascimento</td>
                <td>manipulação</td>
            </tr>
        <?php
            $dados = $p->buscarDados();

            if(count($dados) > 0){
                for($i = 0; $i < count($dados); $i++){
                    echo "<tr>";
                    foreach ($dados[$i] as $key => $value) {
                        if($key != "ID"){
                            echo "<td>".$value."</td>";
                        }
                    }
                    ?>
            <td id="teste"><a href="#">Editar</a>
            
            <a href="?id=<?php echo $dados[$i]['ID']; ?>">Excluir</a></td>

            <?php
            echo "</tr>";
                }
            }else{
                echo "não tem pessoas cadastradas !!";
            }
        ?>

        </table>
    </section>
</body>
</html>

<?php
    if(isset($_GET['id'])){
    $id = addslashes($_GET['id']);
    $p->exclui($id);
    // Atualiza a página
    header("location: index.php");
    }
?>