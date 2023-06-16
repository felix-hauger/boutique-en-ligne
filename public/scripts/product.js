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

async function loggedCartCount(){
    const request = await fetch('cart-count.php');

    const count = await request.text();

    function changeColor(){
        document.getElementById("CartCount").style.color = 'orange';
        document.getElementById("CartCount").classList.remove('fadein');
    }

    function fadeColor(){
        document.getElementById("CartCount").style.color = 'var(--detail-color-)';
        document.getElementById("CartCount").classList.add('fadein');
    }

    changeColor();

    setTimeout(fadeColor, 500);

    if(count != 0){
        document.getElementById('CartCount').innerHTML=count
    }
}

loggedCartCount();

AddCartLogged?.addEventListener('click', async function(ev) {

    if (typeof (Size) != "undefined") {
        const formData = new FormData();

        let quantity = document.getElementById("InputQuantity").value;

        formData.append('product_id', this.value);
        formData.append('product_quantity', quantity);
        formData.append('product_size', Size);

        let request = await fetch('product.php', {
            method: 'post',
            body: formData
        });

        loggedCartCount();

        // console.log(request.text());
    }
});