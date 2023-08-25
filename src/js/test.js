
document.addEventListener('DOMContentLoaded', function () {
   // busquedaKeyPress();
   alertaa();

})

function busquedaKeyPress(){
    const inputs = document.querySelectorAll('.expediente');
    const x = document.querySelector('#X01');
    inputs.forEach(input =>{
        input.addEventListener('input',function(){
        console.log(input.value);
        x.value = input.value;
    });
})

}


function alertaa(){
    const boton = document.querySelector('#act');
    boton.addEventListener('click', function(){
        alert("Diste click");
    })
}