<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\PostModel;
use App\Models\CategoryModel;


class AdminPostController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . '/../templates/admin/views');
    }

    public function createPost():void 
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->readAll();

        $data = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && is_array($data)) {
            $post_title = trim((string)($data['post_title'] ?? ''));
            $post_text = trim((string)($data['post_text'] ?? ''));
            $post_category_id = filter_var($data['category_id'] ?? null, FILTER_VALIDATE_INT);
            $post_status = filter_var($data['post_status'] ?? null, FILTER_VALIDATE_INT);

            if ($post_title === '' || $post_text === '') {
                echo 'O título e o texto do post são obrigatórios.';
                return;
            }

            if ($post_category_id === false || $post_category_id === null) {
                echo 'Selecione uma categoria válida.';
                return;
            }

            if (!$categoryModel->find($post_category_id)) {
                echo 'Categoria inválida.';
                return;
            }

            if ($post_status !== 0 && $post_status !== 1) {
                echo 'Selecione um status válido.';
                return;
            }

            $postModel = new PostModel();
            try {
                $postModel->create(post_title: $post_title, post_text: $post_text, post_category_id: $post_category_id, post_status: $post_status);
                header('Location: ' . URL_ADMIN . '/posts');
                exit();
            } catch (\PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        echo $this->template->render('posts/form.html', [
            'categories' => $categories   
        ]);
    }

    public function editPost(int $id)
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->readAll();
        $postModel = new PostModel();
        $post = $postModel->find($id);
        $data = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && is_array($data)) {
            $post_id = filter_var($id, FILTER_VALIDATE_INT);
            $post_title = trim((string)($data['post_title'] ?? ''));
            $post_text = trim((string)($data['post_text'] ?? ''));
            $post_status = filter_var($data['post_status'] ?? null, FILTER_VALIDATE_INT);
            $post_category_id = filter_var($data['category_id'] ?? null, FILTER_VALIDATE_INT);
            $postModel = new PostModel();
            $post = $postModel->find($id);

            if (!$post) {
                http_response_code(404);
                echo 'Post Não Encontrado';
                return;
            }

            if ($post_title === '' || $post_text === '') {
                echo 'O título e o texto do post são obrigatórios.';
                return;
            }

            if ($post_category_id === false || $post_category_id === null) {
                echo 'Selecione uma categoria válida.';
                return;
            }

            if (!$categoryModel->find($post_category_id)) {
                echo 'Categoria inválida.';
                return;
            }

            if ($post_status !== 0 && $post_status !== 1) {
                echo 'Selecione um status válido.';
                return;
            }

            try {
                $postModel->update(post_id: $post_id, post_title: $post_title, post_text: $post_text, post_category_id: $post_category_id, post_status: $post_status);
                header('Location: ' . URL_ADMIN . '/posts');
                exit();
            } catch (\PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        echo $this->template->render('posts/form.html', [
            'post' => $post,
            'categories' => $categories
        ]);
    }

    public function posts():void
    {
        $postModel = new PostModel();
        $posts = $postModel->readAll();

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->readAll();

        echo $this->template->render('posts.html', [
            
            'posts' => $posts,
            'categories' => $categories
           
        ]);
    }

    public function deletePost(int $id): void
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
    
        $postModel = new PostModel();
        try {
            $postModel->delete($id);
            header('Location: ' . URL_ADMIN . '/posts');
            exit();
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}