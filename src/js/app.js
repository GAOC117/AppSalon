
let paso =1; //si usamos localStorage seria quitar este






document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
})




function iniciarApp() {
    mostrarSeccion();
    tabs(); //cambia la seccion cuando se presionen los tabs
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
            console.log(paso);

            // localStorage.setItem("pasoActual", paso);

            mostrarSeccion();

        })
    })

}