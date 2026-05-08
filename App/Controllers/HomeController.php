<?php

namespace App\Controllers;
use App\Core\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . '/../templates/site/views');
    }

    public function index()
    {
        echo $this->template->render('index.html', [
            'title' => 'Home'
        ]);
    }

    public function videos()
    {
        echo $this->template->render('videos.html', [
            'title' => 'Vídeos'
        ]);
    }

    public function about()
    {
        echo $this->template->render('about.html', [
            'title' => 'Sobre Nós',
        ]);
    }

    public function contact()
    {
        echo $this->template->render('contact.html', [
            'title' => 'Contato',
        ]);
    }

    public function shirts()
    {
        echo $this->template->render('shirts.html', [
            'title' => 'Camisas',
        ]);
    }

    public function waterfalls()
    {
        echo $this->template->render('waterfalls.html', [
            'title' => 'Cachoeiras',
        ]);
    }

}