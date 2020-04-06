<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CheckTypeExtension extends AbstractExtension
{
    public function getFunctions() {
        return array(
            new TwigFunction('isDateTime', [$this, 'isDateTime']),
            new TwigFunction('isBoolean', [$this, 'isBoolean']),
            new TwigFunction('isFloat', [$this, 'isFloat']),
        );
    }

    public function isDateTime($date) {
        return ($date instanceof \DateTime); /* edit */
    }

    public function isBoolean($bool) {
        return is_bool($bool); /* edit */
    }

    public function isFloat($float) {
        return is_float($float); /* edit */
    }

    public function getName()
    {
        return 'check_extension';
    }
}