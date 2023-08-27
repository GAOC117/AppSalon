


let paso = 1; //si usamos localStorage seria quitar este
const pasoInicial = 1;
const pasoFinal = 3;


const cita ={
    id: '',
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
    idcliente();
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
            // const url =`${location.origin}/api/servicios`;
            const url ='/api/servicios';  //si el backend y el JS esten en el mismo dominio
            // const url ='http://127.0.0.1:3000/api/servicios';
            const resultado = await fetch(url);
            const servicios = await resultado.json();
            mostrarServicios(servicios);


    } catch (error) {
        console.log(error);
    }
    
}


//si se pudiera crear un area de notificaciones, que consulte una api y si hay una nueva notificacion mostrarla
// let x=0;
// function reloj(){
//     const npagina = document.querySelector('.app p');
//     npagina.innerHTML='';
//     const parrafo = document.createElement('P');
//     parrafo.textContent = x;
//     parrafo.classList.add('precio-servicio');
//     npagina.appendChild(parrafo);
//     console.log("reloj");
//     x++;
// }
// setInterval(reloj,1000);
//  setInterval(consultarAPI, 3000); prueba para consultar la base de datos para ver si funciona para notificaciones

function mostrarServicios(servicios){


    const hashServicios = document.querySelector('#servicios');
    hashServicios.innerHTML = '';

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

       hashServicios.appendChild(servicioDiv);
       

    })

}

function seleccionarServicio(servicio){
    const { id } = servicio;    
    const { servicios } = cita;
    // console.log(id);

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

    
   
    //  console.log(cita);
}



function idcliente(){
    cita.id = document.querySelector('#id').value;  
}
function nombreCliente(){
    cita.nombre = document.querySelector('#nombre').value;  
}

function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', (e) => {
        const dia = new Date(e.target.value).getUTCDay();
        // console.log(dia);
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
    nombreCliente.innerHTML = `<span>Nombre: </span>${nombre}`;


    //formatear la fecha en español 
const fechaObj = new Date(fecha);
const mes = fechaObj.getMonth();
const dia = fechaObj.getDate() + 2; //porque cada new date desfasa en 1, uno arriba y otro abajo
const year = fechaObj.getFullYear();


const fechaUTC = new Date(Date.UTC(year, mes, dia));

const opciones ={weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}
const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha: </span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora: </span> ${hora} horas`;

    //Boton para crear cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar cita';
    botonReservar.onclick = reservarCita; //si requiere algun parametroa seria = function () { reservarCita(parmetro)}

    
    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    resumen.appendChild(botonReservar);
}


async function reservarCita(){

    const {nombre, fecha, hora, servicios, id} = cita;
    
    const idServicios = servicios.map(servicio => servicio.id)
    
    const datos = new FormData(); //FormData actua como submit en javaScript
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioId', id);
    datos.append('servicios', idServicios);
    
    // datos.append('nombre','corella');
// console.log([...datos]);

    try{

        
        const url = '/api/citas';
        
    const respuesta = await fetch(url,{
        
        method: 'POST',
        body: datos
    });

    const resultado = await respuesta.json();
  
    if(resultado.resultado){
        console.log("si entre");
        Swal.fire({
            icon: 'success',
            title: 'Exito',
            text: 'Cita creada con éxito con el id '+resultado.id,
            button: 'OK'    
            // footer: '<a href="">Why do I have this issue?</a>'
        }).then(()=>{
            setTimeout(() => {
                window.location.reload();
                
            }, 3000);
        })
    }
}
catch(error)
{
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Hubo un error al guardar la cita',
        button: 'OK'
      })
      console.log(error);
}
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




