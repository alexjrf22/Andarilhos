<?php

namespace App\Core;

class Mensagem
{
    private string $message;
    private string $css;

    public function __construct(string $message, string $css = '')
    {
        $this->message = $this->filterMessage($message);
        $this->css = $css;
    }

    public function success(): string
    {
        $this->css = 'font-serif text-green-600 bg-green-100 border border-green-300 rounded p-4';
        $this->message = $this->filterMessage("Sucesso: " . $this->message);
        return $this->render();
    }

    public function filterMessage(string $message): string
    {
        return filter_var($message, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function render(): string
    {
        return "<div class='{$this->css}'>{$this->message}</div>";
    }
}