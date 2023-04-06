<?php

// class Article extends Connexion

class Droits 
{
    private $id;
    public $nom;
    public $bdd;

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
            // parent::__construct();
            
        }
        catch(PDOException $exception)
        {
            echo 'ERREUR :'.$exception->getMessage();
        }
    }

    public function wrightList(){
        $sql = "SELECT * 
                FROM droits";
        $request = $this->bdd->prepare($sql);
        $request->execute();
        // var_dump($request);

        // $list_categ = $request->fetch();
        $wrights = $request->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($wrights);
        return $wrights;
    }
}

$droits = new Droits();