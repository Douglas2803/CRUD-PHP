

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
<section id="esquerda">
        <form action="#" method="post">
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
            <input type="submit"
            value="<?php if(isset($res)){echo 'Atualizar';}
            else{echo 'Cadastrar';}?>"
            >
        </form>
    </section>
</body>
</html>