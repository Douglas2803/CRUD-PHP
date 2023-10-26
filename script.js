const buttons = document.querySelector("button");
const modal = document.querySelector("dialog");

buttons.onclick = function(){
    modal.showModal()
}

function verifica(){

    var nome = document.getElementById("nome").value;
    var dataNascimento = document.getElementById("dataNascimento").value;

    if(nome === "" || dataNascimento === ""){
        alert("complete todos os campos");
        return false;
    }else{
        modal.close();
        return true;
    }
}

