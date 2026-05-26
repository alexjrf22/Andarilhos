<?php 

use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use App\Support\Helpers;


try {

        Router::setDefaultNamespace('App\Controllers');

        /** Rotas API*/
        Router::get('/', 'HomeController@index');
        Router::get('/home', 'HomeController@index');
        Router::get('/sobre', 'HomeController@about');
        Router::get('/contato', 'HomeController@contact');
        Router::get('/loja', 'HomeController@store');
        Router::get('/post/{id}', 'HomeController@post')->where(['id' => '[0-9]+']);
        Router::get('/categoria/{id}', 'HomeController@category')->where(['id' => '[0-9]+']);
        Router::get('/busca', 'HomeController@search');
        Router::get('/busca/ajax', 'HomeController@searchAjax');
        Router::get('/404', 'HomeController@error404');

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
        Helpers::redirect('404');
    }