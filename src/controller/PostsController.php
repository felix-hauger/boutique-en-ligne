<?php


namespace  src\controller;

use  src\controller\AppController;


class   PostsController  extends  AppController  {

    public function __construct(){
        parent::__construct;
        $this -> loadModel('Post');
        $this -> loadModel('Category');
    }

    public function index(){
        $posts = $this -> Post -> last();
        $categories = $this -> Category -> all();
        $this -> render ('posts.index', compact('posts','categories'));
    }

    public function category(){

        $categorie = $this -> Category -> find($_GET['id']);
        if($Categorie === false){
            $this -> notFound();
        }
        $articles = $this -> Post -> lastByCategorie($_GET['id']);
        $categories = $this -> Category -> all();
        $this -> render('posts.category', compact('articles', 'categories', 'categorie'));
    }

    public function show(){
        $article = $this -> Post -> findWithCategory($_GET['id']);
        $this -> render ('posts.show', compact('article'));
    }
}