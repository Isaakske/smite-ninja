<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ThemeExtension extends AbstractExtension
{
    private ?Request $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getMainRequest();
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('saved_theme', [$this, 'getSavedTheme']),
        ];
    }

    public function getSavedTheme(): string
    {
        if ($this->request && ($theme = $this->request->cookies->get('theme'))) {
            return $theme;
        }

        return 'light';
    }
}
