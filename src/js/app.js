
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
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function (){
            seleccionarServicio(servicio);
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDiv);


    })

}

function seleccionarServicio(servicio){
    const { servicios } = cita;

    cita.servicios = [...servicios, servicio];
    console.log(cita);
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




