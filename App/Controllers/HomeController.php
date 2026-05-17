<?php

namespace App\Controllers;
use App\Core\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . '/../templates/site/views');
    }

    public function index():void 
    {
        echo $this->template->render('index.html', [
            'title' => 'NG | Home'
        ]);
    }

    public function videos(): void
    {
        echo $this->template->render('videos.html', [
            'title' => 'NG | Vídeos'
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

    public function waterfalls(): void
    {
        echo $this->template->render('waterfalls.html', [
            'title' => 'NG | Cachoeiras',
        ]);
    }

    public function error404(): void
    {
        echo $this->template->render('404.html', [
            'title' => 'NG | Página Não Encontrada',
        ]);
    }

}