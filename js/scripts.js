function validarFormulario() {
    var monto = document.getElementById("monto").value;
    var tasa = document.getElementById("tasa").value;
    var plazo = document.getElementById("plazo").value;

    if (monto === "" || tasa === "" || plazo === "") {
        Swal.fire({
            icon: 'error',
            title: 'Atención',
            text: 'Por favor, complete todos los campos.'
        });
        return false;
    }

    if (monto < 0 || tasa < 0  || plazo < 0 ) {
        Swal.fire({
            icon: 'error',
            title: 'Atención',
            text: 'Por favor, ingrese valores positivos.'
        });
        return false;
    }

    if (parseFloat(tasa) === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Atención',
            text: 'La tasa de interés no puede ser cero.'
        });
        return false;
    }

    if (parseInt(plazo) === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Atención',
            text: 'El plazo del préstamo en meses no puede ser cero.'
        });
        return false;
    }

    return true;
}

function resetForm() {
    document.getElementById("monto").value = "";
    document.getElementById("tasa").value = "";
    document.getElementById("plazo").value = "";
    var resultado = document.getElementById("resultado");
    if (resultado) {
        resultado.innerHTML = "";
    }
}
