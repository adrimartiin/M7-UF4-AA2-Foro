document.getElementById('title').onblur = validaTitle;
document.getElementById('content').onblur = validaContent;
document.getElementById('formRespuesta').onsubmit = validaForm;


function validaTitle() {
    let title = document.getElementById('title').value;
    let inputTitle = document.getElementById('title');
    let titleError = document.getElementById('title-error');

    if(title === "" || title === null){
        titleError.textContent = "El título no debe estar vacío";
        inputTitle.classList.add("error-border");
        return false;
    } else {
        titleError.textContent = "";
        inputTitle.classList.remove("error-border");
        return true;
    }

}

function validaContent() {
    let content = document.getElementById('content').value;
    let inputContent = document.getElementById('content');
    let contentError = document.getElementById('content-error');

    if(content === "" || content === null){
        contentError.textContent = "El contenido no debe estar vacío";
        inputContent.classList.add("error-border");
        return false;
    } else {
        contentError.textContent = "";
        inputContent.classList.remove("error-border");
        return true;
    }
}

function validaForm(event) {
    event.preventDefault();
    if(validaTitle() && validaContent()){
        document.getElementById("formRespuesta").submit()
    }
}






