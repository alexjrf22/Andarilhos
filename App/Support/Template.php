<?php

namespace App\Support;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Lexer;
use App\Support\Helpers;

class Template
{
   private \Twig\Environment $twig;

   public function __construct(string $dir)
   {
        $loader = new FilesystemLoader($dir);
        $this->twig = new Environment($loader);
        $lexer = new Lexer($this->twig, [
            $this->helpers()
        ]);
        $this->twig->setLexer($lexer);
   }
   
    public function render(string $template, array $data = []): string
    {
          return $this->twig->render($template, $data);
    }

    private function helpers(): void
    {
        $this->twig->addFunction(new \Twig\TwigFunction('url', function (?string $url=null) {
            return Helpers::url($url);
        }));

        $this->twig->addFunction(new \Twig\TwigFunction('summarizeText', function (?string $text = null, ?int $length = null) {
            return Helpers::summarizeText($text, $length);
        }));
    }
}