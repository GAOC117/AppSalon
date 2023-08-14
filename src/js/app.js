

let paso = 1; //si usamos localStorage seria quitar este
const pasoInicial = 1;
const pasoFinal = 3;


const cita ={
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}





document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
})




function iniciarApp() {
    mostrarSeccion();
    tabs(); //cambia la seccion cuando se presionen los tabs
    botonesPaginador();//agrega o quita los botones del paginador
    paginaSiguiente();
    paginaAnterior();
    consultarAPI(); //consulta la API en el backend de php
    nombreCliente(); //añade el nombre del cliente al objeto de cita
    seleccionarFecha(); //añade la fecha de la cita en el objeto
    seleccionarHora(); //añade la hora de la cita en el objeto
    mostrarResumen(); //muestra el resumen de la cita
}


function mostrarSeccion() {

    //ocultar la seccion que tenga la clase de mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }



    // paso = localStorage.getItem("pasoActual");



    //seleccionar la seccion con el paso..
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    //quita la clase de actual al tab anterior
    const tabAnterior = document.querySelector('.actual');
    if (tabAnterior) {
        tabAnterior.classList.remove('actual');
    }

    //resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`)
    tab.classList.add('actual');

}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton => {
        boton.addEventListener('click', function (e) {
            paso = parseInt(e.target.dataset.paso);
            // console.log(paso);

            // localStorage.setItem("pasoActual", paso);

            mostrarSeccion();
            botonesPaginador();

           

        })
    })
}

function paginaSiguiente() {
    const botonSiguiente = document.querySelector('#siguiente');
    botonSiguiente.addEventListener('click', function () {
        if (paso >= pasoFinal) return;
        paso++;


        botonesPaginador();
        mostrarSeccion();

        // console.log(paso);

    })
}


function paginaAnterior() {
    const botonAnterior = document.querySelector('#anterior');
    botonAnterior.addEventListener('click', function () {
        if (paso <= pasoInicial) return;
        paso--;
        // console.log(paso);
        botonesPaginador();
        mostrarSeccion();
    })
}

function botonesPaginador() {

    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if (paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
    }
    else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }


}

async function consultarAPI() {

    try {
            const url ='http://localhost:3000/api/servicios';
            const resultado = await fetch(url);
            const servicios = await resultado.json();
            mostrarServicios(servicios);


    } catch (error) {
        console.log(error);
    }
    
}

function mostrarServicios(servicios){

    servicios.forEach(servicio=>{
        const{id,nombre,precio} = servicio;
        

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = '$'+precio;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id; //data-id-servicio = #
        servicioDiv.onclick = function (){
            seleccionarServicio(servicio);
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDiv);


    })

}

function seleccionarServicio(servicio){
    const { id } = servicio;    
    const { servicios } = cita;
    console.log(id);

    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
    //comprobar si un servicio ya fue agregado o quitarlo
    if(servicios.some(agregado => agregado.id === id )){
        //eliminar
        cita.servicios = servicios.filter(agregado => agregado.id !== id); //regresa  todos los elementos diferentes al id seleccionado y sobre escribe a servicios
        divServicio.classList.remove('seleccionado');
    }else{
        //agregarlo
        cita.servicios = [...servicios, servicio]; //en servicios va acumulando el servicio que se le de click (... spread operator)
        divServicio.classList.add('seleccionado');
    }

    
   
     console.log(cita);
}



function nombreCliente(){
    cita.nombre = document.querySelector('#nombre').value;  
}

function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', (e) => {
        const dia = new Date(e.target.value).getUTCDay();
        console.log(dia);
        if([6,0].includes(dia)){
            e.target.value ='';
            mostrarAlerta('Fines de semana no laboramos', 'error', '.formulario');
        }
        else
        {
            cita.fecha= e.target.value;
        }
    });
}

function seleccionarHora(){
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e) 
    {
    const horaCita = e.target.value;
    const hora = horaCita.split(':')[0];
        if(hora < 10 || hora >= 18){
            e.target.value='';
            mostrarAlerta('Horario no valido', 'error', '.formulario');
        }
        else
        {
            cita.hora = e.target.value;
        }
    })
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true){ //al poner =true hace que no sea obligatorio en la llamada a la funcion

    const alertaPrevia = document.querySelector('.alerta');

    if(alertaPrevia)
        alertaPrevia.remove();
    
    const alerta = document.createElement('DIV');

    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if(desaparece)
    {

        setTimeout(() => {
            alerta.remove();  
        }, 3000);
    }
}


function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');

    
    //limpiar contenido e resumen
    while(resumen.firstChild)
    {
        resumen.removeChild(resumen.firstChild);
    }

    if(Object.values(cita).includes('') || cita.servicios.length ===0){
            mostrarAlerta('Faltan datos de Servicios, Fecha u Hora','error', '.contenido-resumen', false);

            return;
    }
    
    //Formatear el div de resumen
    const { nombre, fecha, hora, servicios} = cita;

//heading para servicios en resumen

const headingServicios  = document.createElement('H3');
headingServicios.textContent = 'Resumen de Servicios';
resumen.appendChild(headingServicios);

//iterando y mostrando los servicios
    servicios.forEach(servicio =>{
         const { id, precio , nombre }  = servicio;

         const contenedorServicio = document.createElement('DIV');
         contenedorServicio.classList.add('contenedor-servicio');

         const textoServicio = document.createElement('P');
         textoServicio.textContent = nombre;

         const precioServicio = document.createElement('P');
         precioServicio.innerHTML = `<span>Precio: </span> $${precio}`;

         contenedorServicio.appendChild(textoServicio);
         contenedorServicio.appendChild(precioServicio);

         resumen.appendChild(contenedorServicio);
    })


    const headingCita  = document.createElement('H3');
headingCita.textContent = 'Resumen de Cita';
resumen.appendChild(headingCita);
    
    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre: </span> "${nombre}"`;

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha: </span> "${fecha}"`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora: </span> "${hora}" horas`;

    
    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

}

// async function prueba() {
    
    
//     let id = document.getElementById('cars').value;
//     let modelo = document.getElementById('modelo')
    
//     try {
//         const url ='http://localhost:3000/api/servicios?id='+id;        
//         const resultado =await fetch(url);
//         const servicios = await resultado.json();
        
     

//         modelo.innerHTML = "";

//         servicios.forEach(serviciox=>{

//             const{id,nombre, precio} = serviciox;
//             const option = document.createElement("option");
//             option.text = nombre+' '+precio;
//             option.value = id;
//             modelo.appendChild(option);
           
//         })

        
//     } catch (error) {
        
//         console.log(error);
// }

// }




