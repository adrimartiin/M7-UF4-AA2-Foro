document.getElementById("nombre_usuario").onblur = validaNombre;
document.getElementById("nombreReal").onblur = validaNombreReal;
document.getElementById("numTelefono").onblur = validaTelf;
document.getElementById("password").onblur = validaPwd;
document.getElementById("repetirPassword").onblur = validaRepePwd; 
document.getElementById("registerLogin").onsubmit = validaRegister;

function validaNombre() {
    let name = document.getElementById("nombre_usuario").value;
    let inputName = document.getElementById("nombre_usuario");
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

function validaNombreReal() {
    let realName = document.getElementById("nombreReal").value;
    let inputRealName = document.getElementById("nombreReal");
    let errorRealName = document.getElementById("error-nombreReal");

    if(realName === "" || realName === null){
        errorRealName.textContent = "Debe ingresar un nombre real.";
        inputRealName.classList.add("error-border");
        return false;
    } else {
        errorRealName.textContent = "";
        inputRealName.classList.remove("error-border");
        return true;
    }
}


function validaTelf() {
    let telf = document.getElementById("numTelefono").value;
    let inputTelf = document.getElementById("numTelefono");
    let errorTelf = document.getElementById("error-telefono");

    if(telf === "" || telf === null){
        errorTelf.textContent = "Debe ingresar un número de teléfono.";
        inputTelf.classList.add("error-border");
        return false;
    } else {
        errorTelf.textContent = "";
        inputTelf.classList.remove("error-border");
        return true;
    }
}

function validaPwd() {
    let password = document.getElementById("password").value;
    let inputPassword = document.getElementById("password");
    let errorPassword = document.getElementById("error-password");

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

function validaRepePwd(){
    let password = document.getElementById("password").value;
    let repeatPassword = document.getElementById("repetirPassword").value;
    let errorRepeatPassword = document.getElementById("error-repetirPassword");
    
    if(repeatPassword === "" || repeatPassword === null){
        errorRepeatPassword.textContent = "Debe repetir la contraseña.";
        document.getElementById("repetirPassword").classList.add("error-border");
        return false;
    } else {
        errorRepeatPassword.textContent = "";
        document.getElementById("repetirPassword").classList.remove("error-border");
        return true;
    }

}

function validaRegister(event) {
    event.preventDefault();
    if(validaName() && validaPsswd()){
        document.getElementById("loginForm").submit()
    }
}