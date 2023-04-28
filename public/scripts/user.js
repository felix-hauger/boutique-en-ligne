let Part;
let counter = 0;
let stock;
let rowspan = 1;
let posstock = 0;

function SelectContent(ContentSelected) {
    document.getElementById("Acceuil").style.display = "none";
    document.getElementById("modifprofil").style.display = "none";
    document.getElementById("VoirAchats").style.display = "none";
    document.getElementById("Adresses").style.display = "none";

    document.getElementById(ContentSelected).style.display = "block";

}

// stocker valeurs dans des arrays ?

while (counter < 5) {
    var Row = document.getElementById("row" + counter);
    var Cells = Row.getElementsByTagName("td");

    if(Cells[0] = stock){
        rowspan++
    }else {
        posstock=counter
        Row.setAttribute("rowspan",rowspan)
        rowspan=1;
    }
    
    
    stock = Cells[0];
    counter++

}

