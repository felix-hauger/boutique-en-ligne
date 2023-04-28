let Stock
let Size

const productButtons = document.querySelector('#BtBox');

const AddCartNotLogged = document.querySelector('#AddNotLogged');
const BuyNotLogged = document.querySelector('#BuyNotLogged');

const AddCartLogged = document.querySelector('#AddLogged');
const BuyLogged = document.querySelector('#BuyLogged');

productButtons.addEventListener('submit', (ev) => {
    ev.preventDefault();
});


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

AddCartLogged?.addEventListener('click', async function(ev) {

    // console.log(this.value);

    if (typeof (Size) != "undefined") {
        const formData = new FormData();

        let quantity = document.getElementById("InputQuantity").value;

        formData.append('product_id', this.value);
        formData.append('product_quantity', quantity);
        formData.append('product_size', Size);
        // console.log(formData);

        let request = await fetch('product.php', {
            method: 'post',
            body: formData
        });

        console.log(request.text());
    }
});