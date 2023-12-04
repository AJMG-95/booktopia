// loginValidation.js

// Función para validar el formulario
function formValidator(event) {
    // Evitar el envío del formulario por defecto
    event.preventDefault();

    // Obtener datos del formulario
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    // Validar campos
    if (!validarCampoRequerido(email, "Correo electrónico es obligatorio")) {
        return;
    }

    if (!validarEmail(email)) {
        alert("Correo electrónico incorrecto");
        return;
    }

    if (!validarCampoRequerido(password, "Contraseña es obligatoria")) {
        return;
    }

    // Si la validación pasa, puedes enviar el formulario
    event.target.submit();
}

// Función para validar campo requerido
function validarCampoRequerido(valor, mensajeError) {
    if (valor.trim() === "") {
        alert(mensajeError);
        return false;
    }
    return true;
}

// Función para validar email
function validarEmail(email) {
    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

// Agregar el evento submit al formulario
document.querySelector("form").addEventListener("submit", formValidator);
