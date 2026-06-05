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
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->readAll();

        echo $this->template->render('about.html', [
            'title' => 'NG | Sobre Nós',
            'categories' => $categories,
        ]);
    }

    public function contact(): void
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->readAll();

        echo $this->template->render('contact.html', [
            'title' => 'NG | Contato',
            'categories' => $categories,
        ]);
    }

    public function store(): void
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->readAll();

        echo $this->template->render('store.html', [
            'title' => 'NG | Loja',
            'categories' => $categories,
        ]);
    }

    public function error404(): void
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->readAll();

        echo $this->template->render('404.html', [
            'title' => 'NG | Página Não Encontrada',
            'categories' => $categories,
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
                'categories' => $categories,
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

        if (!$category) {
            http_response_code(404);
            echo $this->template->render('404.html', [
                'title' => 'NG | Página Não Encontrada',
            ]);
            return;
        }

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

    public function search(): void
    {
        $searchQuery = trim($_GET['searchQuery'] ?? '');

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->readAll();

        $posts = [];
        if ($searchQuery !== '') {
            $postModel = new PostModel();
            $posts = $postModel->search($searchQuery);
        }

        echo $this->template->render('search_results.html', [
            'title' => 'NG | Busca: ' . ($searchQuery ?: 'Resultados'),
            'searchQuery' => $searchQuery,
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    public function searchAjax(): void
    {
        $searchQuery = trim($_GET['searchQuery'] ?? '');
        $posts = [];

        if ($searchQuery !== '') {
            $postModel = new PostModel();
            $posts = $postModel->search($searchQuery);
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'query' => $searchQuery,
            'results' => $posts,
        ], JSON_UNESCAPED_UNICODE);

    }

}