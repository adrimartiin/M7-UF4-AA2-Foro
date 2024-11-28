document.getElementById("username").onblur = validaName;
document.getElementById("password").onblur = validaPsswd;
document.getElementById("loginForm").onsubmit = validaForm;

function validaName() {
    let name = document.getElementById("username").value;
    let inputName = document.getElementById("username");
    let errorName = document.getElementById("error-nombre");

    if(name === "" || name === null){
        errorName.textContent = "Debe ingresar un nombre.";
        inputName.classList.add("error-border");
        return false;
    } else {
        errorName.textContent = "";
        inputName.classList.remove("error-border");
        return true;
    }
}

function validaPsswd() {
    let password = document.getElementById("password").value;
    let inputPassword = document.getElementById("password");
    let errorPassword = document.getElementById("error-pwd");

    if(password === "" || password === null){
        errorPassword.textContent = "Debe ingresar una contraseña.";
        inputPassword.classList.add("error-border");
        return false;
    } else {
        errorPassword.textContent = "";
        inputPassword.classList.remove("error-border");
        return true;
    }
}

function validaForm(event) {
    event.preventDefault();
    if(validaName() && validaPsswd()){
        document.getElementById("loginForm").submit()
    }
}
