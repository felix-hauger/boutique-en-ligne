<?php

class Article
{
    private $id;  
    private $id_article;
    public $articles;
    public $id_utilisateur; 
    public $id_categorie;
    public $date;
    public $bdd;
    public $images;
    public $commentaire;
    public $name;


    public function __construct()
    {
        try
        {
            $options = 
            [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ];
            require('db-config.php');
            $this->bdd = new PDO($DB_SDN, $DB_USER, $DB_PASS, $options);
        }
        catch(PDOException $exception)
        {
            echo 'ERREUR :'.$exception->getMessage();
        }
    }

    //==>PAGE INDEX.PHP
    //Les 3 derniers articles parus
    public function last_articles()
    {
        $sql = "SELECT * 
                FROM `product` 
                ORDER BY date DESC 
                LIMIT 3 ";
        $request = $this->bdd->prepare($sql);
        $request->execute();
        // var_dump($request);

        $list_categ = $request->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($list_categ);
        return $list_categ;
    }

    //==>PAGE HEADER.PHP
    //Liste deroulante : affiche dans la navbar
    public function display_List_Categ_Article()
    {
        $sql = "SELECT *
                FROM category";
        $request = $this->bdd->prepare($sql);
        $request->execute();
        // var_dump($request);

        $list_categ = $request->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($list_categ);
        return $list_categ;
    }

    //==>PAGE CATEGORIE.PHP
    //cree la page selon la categorie
    public function articles_by_id_categ($category_id)
    {
        $this->id_categorie  = $category_id;

        $id_categorie = htmlspecialchars($id_categorie);
        $sql = "SELECT category.name, product.name, product.id_utilisateur,  product.images, product.category_id, product.created_at 
                FROM `category`
                INNER JOIN product ON product.category_id = category.id
                WHERE category.id = ? ";
        $request = $this->bdd->prepare($sql);
        $request->execute([$category_id]);
        // var_dump($request);

        $categ_id = $request->fetchAll(PDO::FETCH_ASSOC);
        // $categ_id = $request->fetchAll();
        // var_dump($categ_id);

        return $categ_id;
    }

    //==>PAGE ARTICLES.PHP ==> PAGINATION
    //(1/2) On determine le nombre total d'articles 
    public function total_number_articles()
    {
        // On determine le nombre total d'articles
        $sql = 'SELECT COUNT(*) AS nb_articles FROM `product`;';
        // On prepare la requete
        $request = $this->bdd->prepare($sql);
        // On execute
        $request->execute();
        // On recupere le nombre d'articles
        $result = $request->fetch();
        //var_dump($result); //OK fonctionne mais probleme lors de l'attribution en int
        $nbArticles = intval($result['nb_articles']) ;
        // var_dump($nbArticles);

        return $nbArticles;
    }
    //==>PAGE ARTICLES.PHP  ==> PAGINATION
        //(2/2)le nombre d'articles par page 
    public function get_by_page($first, $bypage)
    {
        $sql = 'SELECT * FROM `product` ORDER BY `price` DESC LIMIT :premier, :parpage;';
        // On prepare la requete
        $request = $this->bdd->prepare($sql);
        $request->bindValue(':premier', $first, PDO::PARAM_INT);
        $request->bindValue(':parpage', $bypage, PDO::PARAM_INT);
        // On execute
        $request->execute();
        // On recupere les valeurs dans un tableau associatif
        $articles = $request->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($articles);

        return $articles;
    }
    //==>PAGE ARTICLE.PHP
        //(1/5)Creation page article selon son id 
    public function single_article($id)
    {   //$result_art
        $sql ="SELECT * 
                FROM `product` 
                WHERE id = $id ";
        // On prepare la requete
        $request = $this->bdd->prepare($sql);
        // On execute
        $request->execute([$id]);
        // On recupere les valeurs dans un tableau associatif
        // $articles = $request->fetchAll(PDO::FETCH_ASSOC);
        $articles = $request->fetch(PDO::FETCH_ASSOC);
        // var_dump($articles);

        return $articles;
    }
    //==>PAGE ARTICLE.PHP
        //(2/5)Compte : creation page article selon son id  
    public function count_singl_art($id)
    {
        $sql ="SELECT * 
                FROM `product` 
                WHERE id = $id ";
        // On prepare la requete
        $request = $this->bdd->prepare($sql);
        // On execute
        $request->execute([$id]);

        $countArt = $request->rowCount();

        return $countArt;
    }
    //==>PAGE ARTICLE.PHPutilisateurs
    //(3/5)associer commentaire selon id article
    public function commentInf($id)
    {   //$result_art_user 
        $sql ="SELECT *
                FROM product 
                INNER JOIN user ON user.id_utilisateurs   = product.id_utilisateur 
                WHERE product.id = $id";
        // On prepare la requete
        $request = $this->bdd->prepare($sql);
        // On execute
        $request->execute([$id]);
        $commentInf = $request->fetch(PDO::FETCH_ASSOC);
        // var_dump($commentInf);

        return $commentInf  ; //$result_art 
    }

    public function commentInfs($id)
    {   //$result_art_user 
        $sql ="SELECT *
                FROM product 
                INNER JOIN user ON user.id_utilisateurs = product.id_utilisateur 
                WHERE product.id = $id";
        // On prepare la requete
        $request = $this->bdd->prepare($sql);
        // On execute
        $request->execute([$id]);
        $commentInf = $request->fetch(PDO::FETCH_ASSOC);
        var_dump($commentInf);

        return $commentInf  ; //$result_art 
    }

    //==>PAGE ARTICLE.PHP
    //(4/5)associer commentaire selon id article
    public function commentCount($id)
    {   //result_art_cat
        $sql ="SELECT category.id , category.name 
                FROM category 
                INNER JOIN product ON category.id = product.category_id 
                WHERE product.id = $id";
        // On prepare la requete
        $request = $this->bdd->prepare($sql);
        // On execute
        $request->execute([$id]);
        // $request->execute();
        $commentCount = $request->fetch(PDO::FETCH_ASSOC);
        // var_dump($commentCount);

        return $commentCount ;
    }
     //==>PAGE ARTICLE.PHP
    //(5/5)selection des utilisateurs pour leur propres commentaires
    public function commentUser($id)
    {   
        $sql ="SELECT * 
                FROM commentaires 
                INNER JOIN utilisateurs ON utilisateurs.id_utilisateurs = commentaires.id_utilisateur 
                WHERE id_article = ? ORDER BY date DESC";

        // On prepare la requete
        $request = $this->bdd->prepare($sql);
        // On execute
        $request->execute([$id]);
        $comUser = $request->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($comUser);

        return $comUser ;
    }
    //==>PAGE ARTICLE.PHP
    // Creation d'un nouveau  commentaire
    public function insertComment($commentaire, $id_article, $id_utilisateur)
    {   
        $sql ="INSERT INTO `commentaires` (`commentaire`, `id_article`, `id_utilisateur`, `date`) 
                VALUES (?, ?, ?, NOW())";
        // On prepare la requete
        $request = $this->bdd->prepare($sql);
        // On execute
       $newComm = $request->execute([$commentaire, $id_article, $id_utilisateur]);
    }
        



    //==>PAGE CREER-ARTICLE.PHP
    // Creation d'un article selon admin/moderateur
    public function insert_article($article, $images, $id_utilisateur, $id_categorie)
    {
        $this->articles = $article;
        $this->images = $images;
        $this->id_utilisateur = $id_utilisateur;
        $this->id_categorie = $id_categorie;
        // $this->date = $date;

        $article = htmlspecialchars($article);
        $id_categorie = htmlspecialchars($id_categorie);
        // $id_utilisateur = htmlspecialchars($id_utilisateur);

        $sql = "INSERT INTO `articles`(`article`, `images`, `id_utilisateur`, `id_categorie`, `date`) 
        VALUES (?,?,?,?,NOW())";
        $request = $this->bdd->prepare($sql);
        $atr = $request->execute([$article, $images, $id_utilisateur, $id_categorie]);
        // var_dump($atr);
    }

    //CRUD Admin
    public function insert_categorie($name)
    {
        $this->name = $name;

        // $nom = htmlspecialchars($nom);

        $sql = "INSERT INTO `categories` (`nom`) VALUES (?)";
        $request = $this->bdd->prepare($sql);
        $request->execute([$name]);
    }

    
    public function updateCat($id, $nom)
    {
        $this->id = $id;
        $this->nom = $nom;

        // $id = htmlspecialchars($id);
        $id = htmlspecialchars($id, $nom);
        $sql = "UPDATE categories
                SET nom = ?
                WHERE id = ?";
        $request = $this->bdd->prepare($sql);
        $request->execute([$id, $nom]);
    }

    public function updateArt($articles, $images, $id_utilisateur, $id_categorie, $id)
    {   
        $this->articles = $articles;
        $this->images = $images;
        $this->id_utilisateur = $id_utilisateur;
        $this->id_categorie = $id_categorie;
        $this->id = $id;

        $articles = htmlspecialchars($articles);
        $id_categorie = htmlspecialchars($id_categorie);

        $sql ="UPDATE articles 
                SET article = ?, images =?, id_utilisateur = ?, id_categorie = ?, date = NOW()
                WHERE id = ?";
        // On prepare la requete
        $request = $this->bdd->prepare($sql);
        // On execute
        $request->execute([$articles, $images, $id_utilisateur, $id_categorie, $id]);
        // $request->execute();
    }
    

    public function getCatId($id)
    {
        $this->id = $id;
        $sql = "SELECT *
                FROM categories
                WHERE id = ?";
        $request = $this->bdd->prepare($sql);
        $request->execute([$id]);
        $res = $request->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    public function deleteCat($id)
    {   
        $this->id = $id;
        $sql ="DELETE 
                FROM categories 
                WHERE id = ?";
        // On prepare la requete
        $request = $this->bdd->prepare($sql);
        // On execute
        $request->execute([$id]);
    }

    public function deleteArt($id)
    {   
        $this->id = $id;
        $sql ="DELETE 
                FROM articles 
                WHERE id = ?";
        // On prepare la requete
        $request = $this->bdd->prepare($sql);
        // On execute
        $request->execute([$id]);
    }

    public function infArt()
    {   
        $sql ="SELECT *
                FROM articles";
        // On prepare la requete
        $request = $this->bdd->prepare($sql);
        // On execute
        $request->execute();
        // $request->execute();
        $art = $request->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($commentCount);

        return $art ;
    }


    public function getArtByID($id) 
    {   
        $sql ="SELECT * 
                FROM `articles` 
                INNER JOIN categories ON articles.id_categorie = categories.id
                WHERE articles.id = ?";
        // On prepare la requete
        $request = $this->bdd->prepare($sql);
        // On execute
        $request->execute([$id]);
        // $request->execute();
        $art = $request->fetch(PDO::FETCH_ASSOC);

        return $art;
    }

    public function getArt() 
    {   
        $sql ="SELECT * 
                FROM `categories` 
                ORDER BY `id` DESC";
        // On prepare la requete
        $request = $this->bdd->prepare($sql);
        // On execute
        $request->execute();
        // $request->execute();
        $cat = $request->fetchAll(PDO::FETCH_ASSOC);

        return $cat;
        }

    public function commentUserID($id)
    {   
        $sql ="SELECT * 
                FROM commentaires 
                INNER JOIN articles ON articles.id = commentaires.id_article
                WHERE articles.id_utilisateur = ? 
                ORDER BY commentaires.date DESC";

        // On prepare la requete
        $request = $this->bdd->prepare($sql);
        // On execute
        $request->execute([$id]);
        $comUser = $request->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($comUser);

        return $comUser ;
    }
}

$articles = new Article();