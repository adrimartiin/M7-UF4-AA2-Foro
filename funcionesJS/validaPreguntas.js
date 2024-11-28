document.getElementById('title').onblur = validaTitulo;
document.getElementById('content').onblur  = validaContent;
document.getElementById('preguntas-form').onsubmit = validaFormLogin;

function validaTitulo() {
    let titulo = document.getElementById('title').value;
    let inputTitulo = document.getElementById('title');
    let error_titulo = document.getElementById('error-titulo');

    if(titulo === "" || titulo === null){
        error_titulo.innerHTML = "El titulo no debe estar vacío";
        inputTitulo.classList.add("error-border");
        return false;
    } else {
        error_titulo.innerHTML = "";
        inputTitulo.classList.remove("error-border");
        return true;
    }
}

function validaContent() {
    let content = document.getElementById('content').value;
    let inputContent = document.getElementById('content');
    let error_content = document.getElementById('error-content');

    if(content === "" || content === null){
        error_content.innerHTML = "El contenido no debe estar vacío";
        inputContent.classList.add("error-border");
        return false;
    } else {
        error_content.innerHTML = "";
        inputContent.classList.remove("error-border");
        return true;
    }
}

function validaFormLogin(event) {
    event.preventDefault();
    if(validaTitulo() && validaContent()){
        document.getElementById("preguntas-form").submit()
    }
}
    