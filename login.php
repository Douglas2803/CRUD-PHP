<?php
require_once 'Pessoa.php';
session_start();
?>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <div id="login">
        <h1>Fazer login</h1>
        
        <form action="" method="post" id="form">
            <label for="usuario">E-mail</label>
            <input type="usuario" name="usuario" id="usuario">
            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha">
            <input type="submit" name="acao" value="Login">
        </form>
    </div>
    <?php
        if(isset($_POST['acao']) && $_POST['acao'] === 'Enviar'){
            if(empty($_POST['usuario']) || empty($_POST['senha'])){
                echo 'Preencha todos os campos!';
            } else {
                $usuario = $_POST['usuario'];
                $senha = $_POST['senha'];
                $p = new Pessoa('localhost','banco','root','');
                if($p->loginUsuario($usuario, $senha)==true){
                    $_SESSION['usuario_logado'] = true;
                    header('location: index.php');
                }else{
                    echo 'usuário ou senha inválidos';
                }
            }
        }
    ?>

</body>
</html>