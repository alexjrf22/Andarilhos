<?php

namespace App\Support;
require_once 'config.php';

/**
 * Classe de Helpers para funções auxiliares
 */

class Helpers
{
   public static function hello(): string
   {

        $date = date('H');
            switch ($date) {
                case $date >= 0 && $date < 12:
                    return 'Bom dia!';
                case $date >= 12 && $date < 18:
                    return 'Boa tarde!';
                default:  
                    return 'Boa noite!';
            }
   }
   /***resumeText: Função para resumir um texto, removendo tags HTML e limitando o número de caracteres, sem cortar palavras ao meio.
    * @param string $text
    * @param int $limit
    * @param string $continue
    * @return string
    */ 
   public static function summarizeText(string $text, int $limit, string $continue = '...'): string
   {
        $text = trim(strip_tags($text));
        if (mb_strlen($text) <= $limit) {
            return $text;
        }

        $text = mb_substr($text, 0, $limit);
        if (($pos = mb_strrpos($text, ' ')) !== false) {
            $text = mb_substr($text, 0, $pos);
        }

        return $text . $continue;
   }
   
   /**formatValue: Função para formatar um valor numérico como moeda, utilizando vírgula como separador decimal e ponto como separador de milhares.
    * @param float|null $value 
    * ?float indica que o parâmetro pode ser do tipo float ou null. Se o valor for null, a função irá tratá-lo como zero.
    * @return string
    */
   public static function formatValue(?float $value = null): string
   {
        return number_format(($value ? $value: 0) , 2, ',', '.');
   }

   public static function formatNumber(?string $number = null): string
   {
        return number_format($number ? $number: 0 , 0, '.', '.');
   }
   
   public static function countTime(string $date): string
   {
        $now = strtotime(date('Y-m-d H:i:s')); 
        $timestamp = strtotime($date);
        $diff = $now - $timestamp;
        $seconds = $diff;
        $minutes = round($diff / 60);   
        $hours = round($diff / 3600);
        $days = round($diff / 86400);
        $months = round($diff / 2629440);
        $years = round($diff / 31553280);   

        if ($seconds < 60) {
            return 'Há ' . $seconds . ' segundos';
        } elseif ($minutes < 60) {
            return 'Há ' . $minutes . ' minutos';
        } elseif ($hours < 24) {
            return 'Há ' . $hours . ' horas';
        } elseif ($days < 30) {
            return 'Há ' . $days . ' dias';
        } elseif ($months < 12) {
            return 'Há ' . $months . ' meses';
        } else {
            return 'Há ' . $years . ' anos';
        }
   }

   public static function formatDate(string $date, string $format = 'd/m/Y'): string
   {
        $timestamp = strtotime($date);
        return date($format, $timestamp);
   }

   public static function validateEmail(string $email): bool
   {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
   }

   public static function validateUrl(string $url): bool
   {
        if (mb_strlen($url) > 10) {
            return false;
        }
        if (!str_contains($url, '.')) {
            return false;
        }if (str_contains($url, 'http://') && str_contains($url, 'https://')) {
            return true;
        }
        return false;
   }

   public static function localhost(): bool
   {
        $host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? '';
        $host = mb_strtolower(trim($host));
        $host = preg_replace('/:\d+$/', '', $host);
        $localHosts = ['localhost', '127.0.0.1', '::1'];

        return in_array($host, $localHosts, true);
   }

   private static function getBaseUrl(): string
   {
        if (!empty($_SERVER['HTTP_HOST'])) {
            $host = trim($_SERVER['HTTP_HOST']);
            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            return $scheme . '://' . $host;
        }

        return self::localhost() ? URL_DEV : URL_PROD;
   }

   public static function url(string $url): string
   {
        $url = '/' . ltrim($url, '/');
        return self::getBaseUrl() . $url;
   }

   public static function slug(string $text): string
   {
        $text = trim($text);
        $text = mb_strtolower($text);
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = str_replace(' ', '-', $text);
        $text = preg_replace('/[^a-z0-9-]/i', '', $text);
        $text = preg_replace('/-+/', '-', $text);
        $text = trim($text, '-');
        return $text;
   }

   public static function validateCpf(string $cpf): bool
   {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
   }
}