document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
})

function iniciarApp() {
    seleccionarFecha();
}

function seleccionarFecha() {
    const fechaInput = document.querySelector('#fecha');

    fechaInput.addEventListener('change', function (e) {
        const fechaSeleccionada = e.target.value;

        window.location = `?fecha=${fechaSeleccionada}`;
    })
}

function confirmaEliminacion(event) {
    event.preventDefault();
    Swal.fire({
        title: 'Confirmación',
        text: '¿Estás seguro de que deseas eliminar este registro/cita?',
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#3085d6', cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar', cancelButtonText: 'Cancelar'
    }).then((result) => { if (result.isConfirmed) { document.getElementById("formEliminar").submit(); } });
}
