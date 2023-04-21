var Size

function InputQuantityAdd(){
    
    if( document.getElementById("InputQuantity").value < Size){
        document.getElementById("InputQuantity").value++;
    }
    
}

function InputQuantitySub(){
    if( document.getElementById("InputQuantity").value > 1){
        document.getElementById("InputQuantity").value--;
    }
}
$("#QuantityBox button").on('click', function(){
    $('button').removeClass('selected');
    $(this).addClass('selected');
});

function SizeSelected(size,stock){
    document.getElementById("InputQuantity").value = 1
    Size = stock;
    document.getElementById("SizeSelected").value  = size
}


var w = window.innerWidth;


