<?php

namespace Maps_red\TicketingBundle\Twig;

use Maps_red\TicketingBundle\Utils\UrlReplacer;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TicketingExtension extends AbstractExtension
{
    /** @var UrlReplacer $urlReplacer */
    private $urlReplacer;

    /**
     * TicketingExtension constructor.
     * @param UrlReplacer $urlReplacer
     */
    public function __construct(UrlReplacer $urlReplacer)
    {
        $this->urlReplacer = $urlReplacer;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('urlreplacer', [$this, 'getUrlReplacer'], ['is_safe' => ['html']]),
        ];
    }


    /**
     * @param string $text
     * @return string
     */
    public function getUrlReplacer($text)
    {
        return $this->urlReplacer->replacer($text);
    }
}
