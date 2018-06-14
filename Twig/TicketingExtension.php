<?php

namespace Maps_red\TicketingBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TicketingExtension extends AbstractExtension
{
    /** @var array $templates */
    private $templates;

    /** @var array $stylesheets */
    private $stylesheets;

    /** @var array $javascripts */
    private $javascripts;

    /**
     * TicketingExtension constructor.
     * @param array $templates
     * @param array $stylesheets
     * @param array $javascripts
     */
    public function __construct(array $templates, array $stylesheets, array $javascripts)
    {
        $this->templates = $templates;
        $this->stylesheets = $stylesheets;
        $this->javascripts = $javascripts;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('filter_name', [$this, 'doSomething'], ['is_safe' => ['html']]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getTicketingTemplates', [$this, 'getTemplates']),
            new TwigFunction('getTicketingStylesheets', [$this, 'getStylesheets']),
            new TwigFunction('getTicketingJavascripts', [$this, 'getJavascripts']),
            new TwigFunction('getTicketingLayoutTemplate', [$this, 'getLayoutTemplate']),
        ];
    }

    /**
     * @return array
     */
    public function getTemplates(): array
    {
        return $this->templates;
    }

    /**
     * @return array
     */
    public function getStylesheets(): array
    {
        return $this->stylesheets;
    }

    /**
     * @return array
     */
    public function getJavascripts(): array
    {
        return $this->javascripts;
    }

    /**
     * @return string
     */
    public function getLayoutTemplate()
    {
        return $this->templates['layout'];
    }
}
