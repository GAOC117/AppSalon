
document.addEventListener('DOMContentLoaded', function () {
    busquedaKeyPress();

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