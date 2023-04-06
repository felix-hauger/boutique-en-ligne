// On doit: Appeler les donnees
//          Formater les donnees
//          Les trier par ordre alphabetique
//          Les faire apparaitre
//          Les filtrer quand on ecrit dans l'input


// Selection de l'input et du resultat de la recherche

const  searchInput = document.querySelector("#search")
const  searchResult = document.querySelector(".table-results");

//  Fonction qui sert a appeler l'api (ou la page categories.php)

let dataArray;

async  functiongetArt(){
    const res = await fetch("")
    
    // Analyse le corps le corps de la requete et prend ce qu'on veut
    const { results } = await res.json()

    // Tableau qui trie les donnees par ordre alphabetique
    dataArray = orderList(results)
    // Cree une liste
    createArtList(dataArray)

    // Execute la fonction
    getArt()
}

    function orderList(data){
        const orderedData = data.sort((a,b)    // La methode sort trie les lettres
          =>  {
            if(a.name.last.toLowerCase()  <  b.name.last.toLowerCase())
            {
                return -1;
            }

            if(a.name.last.toLowerCase()  >  b.name.last.toLowerCase()){
                return 1;
            }
              return 0;
          })
             return orderedData;
        }

        // Fonction qui fait apparaitre la liste
        function createArtList(ArtList){
            ArtList.forEach(Articles=>{
                const  listItem = documentcreateElement("div");
                listItem.setAttribute("class","table-item");
                listItem.innerHTML = '<div class="container-img"/>
                                     <img  src = "${Article.picture.medium}">
                                        <p class="name">${Article.name}</p>
                                    </div>
                                    <p class="description">${Article.description}</p>
                                    <p class="prix">${Article.prix}</p>'

                                    searchResult.appendChild(list);

                                    })

            // Fonction qui filtre quand on ecrit dans l'input
            
            function  filterData(e){
                searchResult.innerHTML = ""
                const searchedString = e.target.value.toLowerCase().replace(/\s/g,"");  // La methode replace est un regex qui enleve les espaces
                const filteredArr = dataArray.filter(el=>el.name.toLowerCase().includes(searchedString))  ||
                // On verifie si le premier nom ecrit en minuscules de mon tableau est inclus dans la chaine de caractere recherchee
                el.description.toLowerCase().includes(searchString) || '${el.name + el.description}'.toLowerCase().replace(/\s/g,"").includes(searchString))
                //On cree une liste pour filtrer
                createArtList(filteredArr) 
            }
            
        }
        

    
