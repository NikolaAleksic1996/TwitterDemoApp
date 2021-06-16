<?php


namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

// own twig filter extension
class AppExtension extends AbstractExtension implements GlobalsInterface
{
    /**
     * @var string
     */
    private $locale;

    public function __construct(string $locale)
    {
         $this->locale = $locale;
    }

    public function getFilters(): array
    {
        //we created us twig filter extension the name: 'price', and used (500|price)
        return [
            new TwigFilter('price', [$this, 'priceFilter'])
        ];
    }

    public function priceFilter($number): string
    {
        return '$'.number_format($number, 2, '.', ',');
    }

    public function getGlobals(): array
    {
        //global variable 'locale'
        return [
          'locale' => $this->locale
        ];
    }
}