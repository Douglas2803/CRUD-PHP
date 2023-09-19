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
    <?php
    if(isset($_GET['id_up'])){
        $id_update = addslashes($_GET['id_up']);
        $res = $p->buscarDadosPessoa($id_update);
    }
    
    ?>
    <section id="esquerda">
        <form action="#" method="post">
            <h1>Cadastrar Pessoa</h1>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome"
            value="<?php if(isset($res)){echo $res['nome'];}?>"
            >
            <label for="dataNascimento">Data de Nascimento</label>
            <input type="date" name="dataNascimento" id="dataNascimento"
            value="<?php if(isset($res)){echo $res['dataNascimento'];}?>"
            >
            <label for="submit">submit</label>
            <input type="submit" value="submit"
            value="<?php if(isset($res)){echo 'Atualizar';}else{echo 'Cadastrar';}?>"
            >
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
                for($id = 0; $id < count($dados); $id++){
                    echo "<tr>";
                    foreach ($dados[$id] as $key => $value) {
                        if($key != "ID"){
                            echo "<td>".$value."</td>";
                        }
                    }
                    ?>
            <td id="teste">
                <a href="index.php?id_up=<?php echo $dados[$id]['ID']?>">Editar</a>
                <a href="index.php?id=<?php echo $dados[$id]['ID']; ?>">Excluir</a>
            </td>

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

    if(isset($_GET['id_up'])){
        $id = addslashes($_GET['id_up']);
        $p->atualiza($id,$nome,$dataNascimento);
        header("location: index.php");
    }

?>