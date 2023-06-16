<?php

namespace App\Model;

use \App\Config\DbConnection;
use PDO;


class Articles extends AbstractModel{

    private $id;  
    private $id_article;
    public $articles;
    public $id_utilisateur; 
    public $id_categorie;
    public $date;
    public $bdd;
    public $images;
    public $name;


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
    public function articles_by_id_categ($id_categorie)
    {
        $this->id_categorie  = $id_categorie;

        $id_categorie = htmlspecialchars($id_categorie);
        $sql = "SELECT category.name, product.name, product.images, product.category_id, product.created_at 
                FROM `category`
                INNER JOIN product ON product.category_id = category.id
                WHERE category.id = ? ";
        $request = $this->bdd->prepare($sql);
        $request->execute([$id_categorie]);
        // var_dump($request);

        $categ_id = $request->fetchAll(PDO::FETCH_ASSOC);
        // $categ_id = $request->fetchAll();
        // var_dump($categ_id);

        return $id_categorie;
    }

    

    //==>PAGE ARTICLES.PHP ==> PAGINATION
    //(1/2) On determine le nombre total d'articles 
    public function total_number_articles()
    {
      
        // On determine le nombre total d'articles
        $sql = 'SELECT COUNT(*) AS nb_articles FROM `product`;';
        
        // On prepare la requete
        $request = $this->_pdo->prepare($sql);
        
        // On execute
        $request->execute();
        // On recupere le nombre d'articles
        $result = $request->fetch();
        // var_dump($result); //OK fonctionne mais probleme lors de l'attribution en int
        $nbArticles = intval($result['nb_articles']) ;
        // var_dump($nbArticles);

        return $nbArticles;
    }
    //==>PAGE ARTICLES.PHP  ==> PAGINATION
        //(2/2)le nombre d'articles par page 
    public function get_by_page($first, $bypage)
    {
        $sql = 'SELECT * FROM `product` ORDER BY `created_at` DESC LIMIT :premier, :parpage;';
        // On prepare la requete
        $request = $this->_pdo->prepare($sql);
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
        $request = $this->_pdo->prepare($sql);
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
        $request = $this->_pdo->prepare($sql);
        // On execute
        $request->execute([$id]);

        $countArt = $request->rowCount();

        return $countArt;
    }
}

