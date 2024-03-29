<?php
require_once 'Pessoa.php';
session_start();
$p = new Pessoa('localhost','banco','root','');

if(!isset($_SESSION['usuario_logado'])){
   header('location: Login.php');
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="style/style.css">
    <script src="./script.js" defer></script>
</head>
<body>
    <header>
        <button id="cad">Cadastrar Cliente</button>
        <form action="" method="post">
            <input type="submit" value="logout" name="logout" id="logout" class="botoes">
        </form>
    </header>
    <div  id="listaclientes">
        <p>Lista de clientes</p>
    </div>

    <dialog>
        <form action="#" method="post" class="cpessoa">
            <h1>Cadastrar Pessoa</h1>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome"
            value="<?php if(isset($res)){echo $res['NOME'];}?>"
            >
            <label for="dataNascimento">Data de Nascimento</label>
            <input type="date" name="dataNascimento" id="dataNascimento"
            value="<?php if(isset($res)){echo $res['DATA_NASCIMENTO'];}?>"
            >
            <label for="submit">submit</label>
            <input type="submit" name="cadastrar" id="fechar"
            value="<?php if(isset($res)){echo 'Atualizar';}
            else{echo 'Cadastrar';}?>"
            >
        </form>
    <?php
   // Verifica se existe algo no formulário e trata
       if(isset($_POST['nome']) && isset($_POST['dataNascimento'])){
       $nome = addslashes($_POST['nome']);
       $dataNascimento = addslashes($_POST['dataNascimento']);
        }
    
       if(empty($nome) || empty($dataNascimento)){
           echo "Preencha todos os camposssss!";
       } else {
           if(isset($_GET['id_up'])){
               $id_update = addslashes($_GET['id_up']);
               $res = $p->buscarDadosPessoa($id_update);

               // Define $nome e $dataNascimento com os valores recuperados
               $nome = $res['NOME'];
               $dataNascimento = $res['DATA_NASCIMENTO'];
           }

           if($p->insere($nome, $dataNascimento)){
               echo "Pessoa cadastrada/atualizada com sucesso";
           } else {
               echo "A pessoa não foi cadastrada/atualizada";
           }
       }
          if(isset($_GET['id_up'])){
              $id_update = addslashes($_GET['id_up']);
              $res = $p->buscarDadosPessoa($id_update);
          }
    ?>
    </dialog>
    <section id="lista">

            <?php 
            if(isset($_POST['logout'])){
                unset($_SESSION['usuario_logado']);
                header('location: Login.php');
                exit();
            }
            ?>
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
                <a href="index.php?id_up=<?php echo $dados[$id]['ID']; ?>">Editar</a>
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

    if (isset($_GET['id_up'])) {
        $id = addslashes($_GET['id_up']);
    
        // Verifique se 'nome' e 'dataNascimento' estão definidos nos dados POST
        if (isset($_POST['nome']) && isset($_POST['dataNascimento'])) {
            $nome = addslashes($_POST['nome']);
            $dataNascimento = addslashes($_POST['dataNascimento']);
    
            // Chame o método atualiza com os valores corretos
            if ($p->atualiza($id, $nome, $dataNascimento)) {
                header("location: index.php");
                exit; // Saia para evitar a execução adicional do script
            } else {
                echo "Erro ao atualizar a pessoa.";
            }
        } else {
            echo "Preencha todos os campos!";
        }
    }

?>