<?php 

use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use App\Support\Helpers;
require __DIR__ . '/App/Support/config.php';


try {

        Router::setDefaultNamespace('App\Controllers');

        /** Rotas API*/
        Router::get('/', 'AppController@index');
        Router::get('/home', 'AppController@index');
        Router::get('/sobre', 'AppController@about');
        Router::get('/contato', 'AppController@contact');
        Router::get('/loja', 'AppController@store');
        Router::get('/post/{id}', 'AppController@post')->where(['id' => '[0-9]+']);
        Router::get('/categoria/{id}', 'AppController@category')->where(['id' => '[0-9]+']);
        Router::get('/busca', 'AppController@search');
        Router::get('/busca/ajax', 'AppController@searchAjax');
        Router::get('/404', 'AppController@error404');

        // Routes for admin panel // Rotas administrativas
        Router::group([], function() {      
            Router::get(URL_ADMIN, 'AdminController@index');
            Router::get(URL_ADMIN . '/dashboard', 'AdminController@dashboard');
            Router::get(URL_ADMIN . '/contato', 'AdminController@contatc');
            Router::get(URL_ADMIN . '/sobre', 'AdminController@about');

            //admin posts
            Router::get(URL_ADMIN . '/posts', 'AdminController@posts');
            Router::match(['get', 'post'], URL_ADMIN . '/post/cadastrar', 'AdminPostController@createPost');
            Router::match(['get','post','put'], URL_ADMIN . '/post/editar/{id}', 'AdminPostController@editPost')->where(['id' => '[0-9]+']); 
            Router::delete(URL_ADMIN . '/post/deletar/{id}', 'AdminPostController@deletePost')->where(['id' => '[0-9]+']);
            
            //admin categories
            Router::get(URL_ADMIN . '/categorias', 'AdminController@category');
            Router::match(['get', 'post'], URL_ADMIN . '/categoria/cadastrar', 'AdminCategoryController@createCategory');
            Router::match(['get', 'post', 'put'], URL_ADMIN . '/categoria/editar/{id}', 'AdminCategoryController@editCategory')->where(['id' => '[0-9]+']);
            Router::delete(URL_ADMIN . '/categoria/deletar/{id}', 'AdminCategoryController@deleteCategory')->where(['id' => '[0-9]+']);
        });
      
        /** Rota para servir arquivos estáticos (CSS, JS, imagens) */
        Router::get('/assets/{path}', function (string $path) {
            $file = __DIR__ . '/App/templates/assets/' . $path;

            if (is_dir($file) || !file_exists($file)) {
                http_response_code(404);
                echo 'Arquivo não encontrado';
                return;
            }

        /** Determina o tipo MIME com base na extensão do arquivo, usando uma correspondência simples. 
        *  Se a extensão não for reconhecida, tenta usar mime_content_type ou retorna um tipo genérico.  
        *  Isso é importante para garantir que o navegador interprete corretamente o conteúdo servido. 
        *  @param PATHINFO_EXTENSION é uma constante do PHP que retorna a extensão do arquivo, 
        *  @estrutura de controle => match é uma estrutura de controle que compara o valor da extensão com os casos definidos.
        *  @param mime_content_type é uma função do PHP que tenta determinar o tipo MIME de um arquivo com base em seu conteúdo,
        *  @param application/octet-stream é um tipo MIME genérico usado quando o tipo específico 
        *  não pode ser determinado, indicando que o conteúdo é um fluxo de bytes arbitrário.
        */

            $extension = pathinfo($file, PATHINFO_EXTENSION);
            $mime = match ($extension) {
                'css' => 'text/css',
                'js' => 'application/javascript',
                'svg' => 'image/svg+xml',
                'png' => 'image/png',
                'jpg', 'jpeg' => 'image/jpeg',
                'gif' => 'image/gif',
                default => mime_content_type($file) ?: 'application/octet-stream',
            };

            header('Content-Type: ' . $mime);
            readfile($file);
        })->where(['path' => '.*']);

        /** Rotas para evitar erros de requisição no servidor.  */

        /**  Rota para .well-known para evitar erros de requisições automáticas do navegador */
        Router::get('/.well-known/{path}', function (string $path) {
            http_response_code(204);
            return '';
        })->where(['path' => '.*']);

        /**  Rota para favicon.ico para evitar erros 404 no console do navegador */
        Router::get('/favicon.ico', function () {
            http_response_code(204);
            return '';
        });

        Router::start();

    }catch(NotFoundHttpException $e){
        $requestedUrl = $_SERVER['REQUEST_URI'] ?? '/';
        Helpers::redirect('404?requested_url=' . urlencode($requestedUrl));
    }