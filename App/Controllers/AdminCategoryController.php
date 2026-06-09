<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\PostModel;
use App\Models\CategoryModel;


class AdminCategoryController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . '/../templates/admin/views');
    }

    public function createCategory():void 
    {
        $data = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && is_array($data)) {

            $category_name = trim(strip_tags((string)($data['category_name'] ?? '')));
            $category_description = isset($data['description']) ? trim(strip_tags((string)$data['description'])) : null;
            $category_status = isset($data['status']) ? (int)$data['status'] : 0;
            $categoryModel = new CategoryModel();
            try{
                $categoryModel->create(category_name: $category_name, category_description: $category_description, category_status: $category_status);
                header('Location: ' . URL_ADMIN . '/categorias');
                exit();
            } catch (\PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        echo $this->template->render('categories/form.html', [
            
           
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

    public function editCategory(int $id): void
    {
        $categoryModel = new CategoryModel();
        $category = $categoryModel->find($id);

        if (!$category) {
            http_response_code(404);
            echo 'Categoria não encontrada';
            return;
        }

        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && is_array($data)) {
            $category_name = trim((string)($data['category_name'] ?? ''));
            $category_description = isset($data['description']) ? (string)$data['description'] : '';
            $category_status = isset($data['status']) ? (int)$data['status'] : 0;

            if ($category_name === '') {
                echo 'O nome da categoria é obrigatório.';
                return;
            }

            try {
                $categoryModel->update($id, category_name: $category_name, category_description: $category_description, category_status: $category_status);
                header('Location: ' . URL_ADMIN . '/categorias');
                exit();
            } catch (\PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        echo $this->template->render('categories/form.html', [
            
            'category' => $category
           
        ]);
    }

    public function deleteCategory(int $id): void
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
    
        $categoryModel = new CategoryModel();
        try {
            $categoryModel->delete($id);
            header('Location: ' . URL_ADMIN . '/categorias');
            exit();
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}