const buttons = document.querySelector("button");
const modal = document.querySelector("dialog");
const buttonClose = document.getElementById("fechar");


buttons.onclick = function(){
    modal.showModal()
}

buttonClose.onclick = function(){
    modal.close()
} 