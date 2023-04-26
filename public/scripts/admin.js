var page
var users

$("#CPbuttons button").on('click', function(){
    $('button').removeClass('selected');
    $(this).addClass('selected');
    page = $(this).val();
    FetchContent(page)
});

function FetchContent(page){
    fetch('/boutique-en-ligne/src/view/admin_'+page+'.php').then(function (response) {
       
        return response.text();
    }).then(function (html) {
        // This is the HTML from our response as a text string
        document.getElementById("Main").innerHTML = html
    }).catch(function (err) {
        // There was an error
        console.warn('Something went wrong.', err);
    });
}
function RedirectAddProduct(){
    window.location="add-product.php"
}