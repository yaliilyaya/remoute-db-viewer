<?php


namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends  AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('applyColumnDecorator', [ColumnDecoratorExtension::class, 'applyColumnDecorator']),
        ];
    }
}