//Función para validar el formulario
function formValidation(event) {
    //Evitar el envio del formulario por defecto
    event.preventDefault();

    //Obtner datos del formulario
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    //validar Campos

    if (!validarCampoRequerido(email, "EL correo electrónico es obligatorio")) {
        return;
    }

    if (!validarEmail(email)) {
        alert("Correo electronico no valido");
    }

    if (!validarCampoRequerido(password, "La contraseña es obligatoria")) {
        return;
    }

    //Si la validación pasa, se puede enviar el formulario
    event.target.submit();
}

//Funcion para Validar campo requerido
function validarCampoRequerido(valor, mensajeError) {
    if (valor.trim === "") {
        alert(mensajeError);
        return false;
    }
    return true;
}

//Función para validar el email
function validarEmail(email) {
    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

//Agrega el evento de submit al formulario
window.onload = function() {
    var form = document.getElementById('loginForm');
    if(form) {
        form.addEventListener('submit', formValidation);
    }
}
