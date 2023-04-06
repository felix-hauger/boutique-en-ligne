
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">

<link   rel= stylesheet    href=style.css />
<link   rel="preconnect"  href="https://fonts.googleapis.com"/>
<link   rel="preconnect"  href="https://fonts.gstatic.com" crossorigin/>
<link   href="https://fonts.googleapis.com/css2?family=Lato:wght@100;
300;400;700;900&family=Roboto:wght@100;300;400;500;700;900&display=swap"
rel= stylesheet/>
</head>

<body>
    <script src = "script.js"></script>
    <div class= "global-container">
    
    <nav class="side-nav">
    <div class="nav-logo">
    <img src="images/logo.svg">
    <h1>Users</h1>
    </div>
    <!-- A copier autant de fois qu'il y a de categories et remplacer nom "image" et "span" -->
    <a href="#"  class="bloc-link"> 
        <img src="images/dashboard.svg">
        <span class="nav-links">Dashboard</span>

    </a> 
    </nav>
    
    <main class="main">
        <div class="input-control">
            <label  for="search">
              <img src="images/search.svg">
           </label>
           <input  type="text"  id="search"  placeholder="search for an user">
        </div>
        <h2  class="main-title">Database Results</h2>
        <div  class="table">
            <h3  class="table-title">Email</h3>
            <h3  class="table-title">Phone</h3>
        </div>
        
        <div  class="table-results">
            <div class="table-item">
                <div class="container-img">
                    <img src="">
                    <p class="name">Nom du produit</p>
                 </div>
                 <p class="description">Description</p>
                 <p class="prix">Prix</p>
                </div>
                </div>
    </main>
</div>
</body>
</html>