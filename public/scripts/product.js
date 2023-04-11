
function InputQuantityAdd(ValMax){
    if( document.getElementById("InputQuantity").value < ValMax){
        document.getElementById("InputQuantity").value++;
    }
    
}

function InputQuantitySub(){
    if( document.getElementById("InputQuantity").value > 1){
        document.getElementById("InputQuantity").value--;
    }
}
