<?php
class Pessoa{
    private $conexao;

    public function __construct($servidor,$banco,$usuario,$senha){
        try{
            $this->conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $erro) {
            echo "ERRO com banco: " . $erro->getMessage();
        } catch (Exception $e) {
            echo "Erro genérico: " . $e->getMessage();
        }
        }

    public function insere($nome,$dataNascimento){

        //verifica se o e-mail já está cadastrado
        $stmt = $this->conexao->prepare("SELECT ID FROM cliente WHERE NOME = :nome");
        $stmt->bindParam(':nome',$nome);

        $stmt->execute();

        if($stmt->rowCount() == 0 ){

            $stmt = $this->conexao->prepare("INSERT INTO cliente (NOME,DATA_NASCIMENTO) VALUES (:nome,:data_nascimento)");
            $stmt->bindParam(':nome',$nome);
            $stmt->bindParam(':data_nascimento',$dataNascimento);

            $stmt->execute();

            return true;

        }else{
            return false;
        }

    }

    public function exclui($id){
        $stmt = $this->conexao->prepare("DELETE FROM cliente WHERE id = :id");
        $stmt->bindParam(":id",$id);
        $stmt->execute();
    }

    public function atualiza($id,$nome,$dataNascimento){
        $stmt = $this->conexao->prepare("SELECT ID FROM cliente WHERE NOME = :nome");
        $stmt->bindParam(':nome',$nome);

        $stmt->execute();

        if($stmt->rowCount() > 0 ){
            return false;
        }else{
            $stmt = $this->conexao->prepare("UPDATE cliente  SET NOME = :nome, DATA_NASCIMENTO = :dataNascimento  WHERE id = :id");
            $stmt->bindParam(":id",$id);
            $stmt->bindParam(":nome",$nome);
            $stmt->bindParam(":dataNascimento",$dataNascimento);
            $stmt->execute();
            return true;
        }

    }

    public function buscarDado($id){
        $resultado = array();
        $stmt = $this->conexao->prepare("SELECT * FROM cliente WHERE id = :id");
        $stmt->bindValue(":id",$id);
        $stmt->execute();
        // para um unica linha
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        // para mais que uma linhas
        // $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public function buscarDados(){
        $resultado = array();
        $stmt = $this->conexao->prepare("SELECT * FROM cliente ORDER BY nome");
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
        // para um unica linha
        // $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        // para mais que uma linhas fetchAll(PDO::FETCH_ASSOC);

    }

    public function buscarDadosPessoa($id){
        $res = [];
        $stmt = $this->conexao->prepare("SELECT *FROM cliente WHERE id=:id");
        $stmt->bindValue(":id",$id);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    public function loginUsuario($usuario, $senha){
        $stmt = $this->conexao->prepare("SELECT * FROM funcionario WHERE USUARIO = :usuario");
        $stmt->bindValue(":usuario", $usuario);
        $stmt->execute();
        $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($usuarioEncontrado['USUARIO']==$usuario &&  $usuarioEncontrado['SENHA']==$senha){
            // A senha está correta, autenticar o usuário
            
            $_SESSION['usuario'] = $usuario; 
            return true;

            exit; // Certifique-se de sair para evitar a execução adicional do código
        } else {
            return false;
            exit;
        }
    }
}