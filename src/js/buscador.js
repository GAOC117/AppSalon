document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});

function iniciarApp(){
    buscarPorFecha();
    // test();
}


function buscarPorFecha(){
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input',function(e){
        const fechaSeleccionada = e.target.value;
        window.location = `?fecha=${fechaSeleccionada}`;
});
}


// function test(){
//     const sele= document.querySelector('#sele');
//     sele.addEventListener('input',function(e){
//      console.log(consultarAPI(sele.value));
//     })
// }

// async function consultarAPI(ide) {

//     try {
//         const par = document.querySelector('#par');
//         par.innerHTML ='';
//             const url ='http://localhost:3000/api/servicios?id='+ide;
//             // const url ='http://127.0.0.1:3000/api/servicios';
//             const resultado = await fetch(url);
//             const servicios = await resultado.json();
//             console.log(servicios);
//             const{id,nombre,precio} = servicios;
            

//               par.innerHTML = id + " "+nombre+" "+precio;


//     } catch (error) {
//         console.log(error);
//     }
    
// }
