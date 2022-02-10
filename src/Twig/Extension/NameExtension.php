<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NameExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('portal_name', [$this, 'getPortalName']),
        ];
    }

    public function getPortalName(int $portal): string
    {
        switch ($portal) {
            case 1: return 'Hi-Rez';
            case 5: return 'Steam';
            case 9: return 'Playstation';
            case 10: return 'Xbox';
            case 22: return 'Nintendo';
            case 25: return 'Discord';
            case 28: return 'Epic Games';
            default: return 'Unknown';
        }
    }
}
