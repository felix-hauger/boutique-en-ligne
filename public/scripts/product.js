var Stock
var Size

function InputQuantityAdd() {

    if (document.getElementById("InputQuantity").value < Stock) {
        document.getElementById("InputQuantity").value++;
    }

}

function InputQuantitySub() {
    if (document.getElementById("InputQuantity").value > 1) {
        document.getElementById("InputQuantity").value--;
    }
}

$("#QuantityBox button").on('click', function () {
    $('button').removeClass('selected');
    $(this).addClass('selected');
});

function SizeSelected(size, stock) {
    document.getElementById("InputQuantity").value = 1
    Stock = stock;
    Size = size;
}

function Cookie(id_produit) {
    quantity = document.getElementById("InputQuantity").value
    if (typeof (Size) != "undefined") {
        product = 'product' + '_' + id_produit + '_' + Size;

        document.cookie = product + " = " + quantity + ";expires=Fri, 31 Dec 9999 23:59:59 GMT"
        CartCount()
    }
}


