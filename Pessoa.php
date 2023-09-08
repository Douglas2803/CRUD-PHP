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

    function insere($nome,$dataNascimento){
    
        //verifica se o e-mail já está cadastrado
        $stmt = $this->conexao->prepare("SELECT * FROM cliente WHERE NOME = :nome");
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
    
    function exclui($id){
        $stmt = $this->conexao->prepare("DELETE FROM cliente WHERE id = :id");
        $stmt->bindParam(":id",$id);
        $stmt->execute();
    }
    
    function atualiza($id,$nome){
        $stmt = $this->conexao->prepare("UPDATE cliente  SET nome = :nome  WHERE id = :id");
        $stmt->bindParam(":id",$id);
        $stmt->bindParam(":nome",$nome);
        $stmt->execute();
    }
    
    function buscarDado(){
        $stmt = $this->conexao->prepare("SELECT * FROM cliente WHERE id = :id");
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        // para um unica linha 
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        // para mais que uma linhas
        // $resultado = $stmt->fetchAll();
    
        return $resultado;
    }

    function buscarDados(){
        $resultado = array();
        $stmt = $this->conexao->prepare("SELECT * FROM cliente ORDER BY nome");
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
        // para um unica linha 
        // $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        // para mais que uma linhas fetchAll(PDO::FETCH_ASSOC);
    
    }
}