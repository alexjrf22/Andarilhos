<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\PostModel;
use App\Models\CategoryModel;


class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . '/../templates/admin/views');
    }

    public function index():void 
    {
    

        echo $this->template->render('index.html', [
            
           
        ]);
    }

    public function dashboard():void 
    {
    

        echo $this->template->render('dashboard.html', [
            
           
        ]);
    }

    public function posts():void
    {
        $postModel = new PostModel();
        $posts = $postModel->readAll();

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->readAll();

        echo $this->template->render('posts/posts.html', [
            
            'posts' => $posts,
            'categories' => $categories
           
        ]);
    }

    public function about():void
    {
        echo $this->template->render('about.html', [
            
        
        ]);
    }

    public function contatc():void
    {
        echo $this->template->render('contatc.html', [
            
        
        ]);
    }

    public function category():void
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->readAll();
        echo $this->template->render('categories/category.html', [
            'categories' => $categories
        ]);
    }

    

   

}