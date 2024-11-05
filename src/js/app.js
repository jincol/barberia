
let paso = 1;
const inicial = 1;
const final = 3;

//OBJETO CITAS
const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function () {
    inciarApp();
})

function inciarApp() {
    mostrandoSeccion(); //Muestra y oculta las secciones
    tabs(); //Cambia las secciones cuando se presiona los tabs
    botonesPaginador(); //AGREGAR O QUITA BOTONES ANTERIOR / SIGUEITNE
    botonAnterior();
    botonSiguiente();
    consultarAPI(); //CONSULTA LA API EN EL BACKDEN DE PHP
    obtenerIdCliente();
    ObtenerNombreCliente(); //AÑADE EL NOMBRE DEL CLIENTE A CITA.NOMBRE
    seleccionafecha(); //AÑADE FECHA A CITA
    seleccionaHora();//AÑADE LA HORA DE LA CITA
    muestraResumen() //MUESTRA EL RESUMEN DE EL SERVICIO
}

function mostrandoSeccion() {
    //OCULTAR LOS QUE TENGAN LA CLASE MOSTRAR 
    const seccionOculto = document.querySelector('.mostrar')
    if (seccionOculto) {
        seccionOculto.classList.remove('mostrar');
    }

    //SELECCIONA LA SECCION CON EL PASO
    const seccion = document.querySelector(`#paso-${paso}`);
    seccion.classList.add('mostrar')


    const tabactual = document.querySelector('.actual');
    if (tabactual) {
        tabactual.classList.remove('actual');
    }
    //RESALTA EL TAB ACTUAL
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton => {
        boton.addEventListener('click', function (e) {
            paso = parseInt(e.target.dataset.paso);
            mostrandoSeccion();

            botonesPaginador();

        })
    })
}

function botonesPaginador() { //Oculta y muestra el ultimo boton
    const pagAnterior = document.querySelector('#anterior');
    const pagSiguiente = document.querySelector('#siguiente');

    if (paso === 1) {
        pagAnterior.classList.add('ocultar');
        pagSiguiente.classList.remove('ocultar');
    } else if (paso === 3) {
        pagAnterior.classList.remove('ocultar');
        pagSiguiente.classList.add('ocultar');
        muestraResumen();
    } else {
        pagAnterior.classList.remove('ocultar');
        pagSiguiente.classList.remove('ocultar');
    }

    mostrandoSeccion();
}

function botonAnterior() {
    const botonAnt = document.querySelector('#anterior');
    botonAnt.addEventListener('click', function () {

        if (paso <= inicial) return;
        paso--;
        botonesPaginador();
    })
}

function botonSiguiente() {
    const botonSig = document.querySelector('#siguiente')
    botonSig.addEventListener('click', function () {
        if (paso >= final) return;
        paso++;
        botonesPaginador();
    })
}

async function consultarAPI() {

    try {
        const url = 'http://localhost:443/api/servicios'; //URL DE LA API
        const resultado = await fetch(url); //ESTO TRAE EL API
        const servicios = await resultado.json(); //Convierte la api en formato json
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios) {

    servicios.forEach(servicio => {

        const { id, nombre, precio } = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$ ${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicios');
        servicioDiv.dataset.idServicio = id;//ATRIBUTOS PERZONALIZADO

        servicioDiv.onclick = function () {
            seleecionarServicio(servicio);
        };

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDiv);
    })

}

function seleecionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`)

    //COMPORBAR SI UN SERVICIO FUE AGREGADO O QUITARLO
    if (servicios.some(agregado => agregado.id === id)) {
        //ELIMINAR
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');
    } else {
        // AGREGAR
        cita.servicios = [...servicios, servicio];

        divServicio.classList.add('seleccionado');
    }

}

function obtenerIdCliente() {
    const id = document.querySelector('#id').value;

    cita.id = id;
}

function ObtenerNombreCliente() {
    const nombre = document.querySelector('#nombre').value;

    cita.nombre = nombre;
}

function seleccionafecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function (e) {

        const dia = new Date(e.target.value).getUTCDay();

        if ([6, 0].includes(dia)) {
            e.target.value = "";
            mostrarAlerta("Fines de semana no disponible", 'error', '.formulario');
        } else {
            cita.fecha = e.target.value;
        }
    })
}

function seleccionaHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', (e) => {

        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];

        if (hora < 10 || hora > 18) {
            e.target.value = "";
            mostrarAlerta("HORARIO NO DISPONIBLE", 'error', '.formulario')
        } else {
            cita.hora = e.target.value;
        }

    })
}

function mostrarAlerta(mensaje, tipo, elemento, tiempoActivo = true) {
    //VERIFICA SI HAY UNA ALERTA
    const alertsPrevia = document.querySelector('.alerta');
    if (alertsPrevia) {
        alertsPrevia.remove(); //SI una alerta elimna otra
    }

    // SCRIPTING PARA CREAR ALERTA
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta')
    alerta.classList.add(tipo)

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if (tiempoActivo) {
        // ELIMINAMOS DESPUES DE UNOS SEGUNDOS LA ALERTA 
        setTimeout(() => {
            alerta.remove();
        }, 3000)
    }
}

function muestraResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    //LIMPIAR CONTENIDO DE RESUMEN
    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }


    //BUSCA SI FALATA UN DATO EN CITAS Y SERVICIO
    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Faltan datos de servicio, fecha u hora', 'error', '.contenido-resumen', false)

        return;
    }

    //FORMATEAR EL DIV DE RESUMEN
    const { nombre, fecha, hora, servicios } = cita;


    //HEADING PARA SERVICIO-RESUMEN
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = "Resumen de servicios";
    resumen.appendChild(headingServicios);


    servicios.forEach((servicio) => {

        const { id, precio, nombre } = servicio;

        const contenedorServicios = document.createElement('DIV');
        contenedorServicios.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio :</span> $ ${precio}`

        contenedorServicios.appendChild(textoServicio);
        contenedorServicios.appendChild(precioServicio);

        resumen.appendChild(contenedorServicios);

    });

    //HEADING PARA RESUME DE LA CITA
    const headingCita = document.createElement('H3');
    headingCita.textContent = "Resumen de Cita";
    resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre : </span> ${nombre}`;

    //FORMATEAR FECHA
    const objFecha = new Date(fecha); //Obetenemos el objeto date pasando la fecha de resgitrso como parametro
    const mes = objFecha.getMonth(); //Sumamos Uno para igual el mes y no salaga uno anterior

    //EN CADA new Date se resta un dia , si declaras 3 date suma mas 3
    const dia = objFecha.getDate() + 2; //Sumanos el 1 para iguaa y no devuelva un anterior
    const year = objFecha.getFullYear(); //devuelve el año 2024

    const fechaUTC = new Date(Date.UTC(year, mes, dia)); //Retorna la fecha en UTC codigo 

    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const fechaFormateada = fechaUTC.toLocaleDateString("es-PE", opciones)


    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha Reserva: </span> ${fechaFormateada}`;


    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora : </span> ${hora}`;

    // BOTON PARA CITA
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita; //LLAMAMOS A LA FUNCION SI () SE LLAMARA EN CADA CLIK



    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.appendChild(botonReservar);

}

async function reservarCita() {
    const { id, fecha, hora, servicios } = cita; // Destructuramos el objeto cita
    const idservicios = servicios.map(servicio => servicio.id);

    const datos = new FormData();

    datos.append('fecha', fecha);
    datos.append('hora', hora); //hora es una variable , hora es valor , llave,valor llave=>$valor
    datos.append('usuarioId', id);
    datos.append('servicios', idservicios);

    // console.log([...datos]); //Para debugear lo que se esta mandando 
    // return; 

    try {
        // PETICION HACIA LA API
        const url = 'http://localhost:3000/api/citas'

        const respuesta = await fetch(url, {
            method: 'POST',//CUANDO VAS A ENVIAR UNA PETICION POST ES OBLIGATORIO LA CONFIGURACION METHOD_>POST
            body: datos //Envia los datos  de form-data mediante post que recibe el API controller de php en la funcion guardar
        })

        const resultado = await respuesta.json(); // Convierte en JSON

        if (resultado.resultado) {
            Swal.fire({
                icon: "success",
                title: "Cita Creada",
                text: "Tu cita fue registrada correctamente !",
                boton: 'Ok'
            }).then(() => {
                window.location.reload();
            });
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error de Creacion",
            text: "Algo sucedio en el registro!",
        })
    }
}
