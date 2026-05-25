<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\PostModel;
use App\Models\CategoryModel;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . '/../templates/site/views');
    }

    public function index():void 
    {
        $postModel = new PostModel();
        $posts = $postModel->readAll();

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->readAll();

        echo $this->template->render('index.html', [
            'title' => 'NG | Home',
            'posts' => $posts,
            'categories' => $categories
        ]);
    }

    public function about(): void
    {
        echo $this->template->render('about.html', [
            'title' => 'NG | Sobre Nós',
        ]);
    }

    public function contact(): void
    {
        echo $this->template->render('contact.html', [
            'title' => 'NG | Contato',
        ]);
    }

    public function shirts(): void
    {
        echo $this->template->render('shirts.html', [
            'title' => 'NG | Camisas',
        ]);
    }

    public function error404(): void
    {
        echo $this->template->render('404.html', [
            'title' => 'NG | Página Não Encontrada',
        ]);
    }

    public function post(int $id): void
    {
        $postModel = new PostModel();
        $post = $postModel->find($id);

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->readAll();

        if (!$post) {
            http_response_code(404);
            echo $this->template->render('404.html', [
                'title' => 'NG | Página Não Encontrada',
            ]);
            return;
        }

        echo $this->template->render('post.html', [
            'title' => 'NG | ' . $post['post_title'],
            'post' => $post,
            'categories' => $categories
        ]);
    }

    public function category(int $id): void
    {
        $categoryModel = new CategoryModel();
        $category = $categoryModel->find($id);

        // if (!$category) {
        //     http_response_code(404);
        //     echo $this->template->render('404.html', [
        //         'title' => 'NG | Página Não Encontrada',
        //     ]);
        //     return;
        // }

        $categories = $categoryModel->readAll();

        $postModel = new PostModel();
        $posts = $postModel->findByCategory($id);

        echo $this->template->render('category.html', [
            'title' => 'NG | Categoria: ' . $category['category_name'],
            'category' => $category,
            'posts' => $posts,
            'categories' => $categories
        ]);
    }

}