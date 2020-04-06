<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class StringExtension extends AbstractExtension
{
    public function getFunctions() {
        return array(
            new TwigFunction('json_decode', [$this, 'json_decode'])
            
        );
    }

    public function json_decode($string) {
        return json_decode($string);
    }
}