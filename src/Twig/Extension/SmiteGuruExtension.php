<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Entity\Player;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SmiteGuruExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('smite_guru_url', [$this, 'getSmiteGuruUrl']),
        ];
    }

    public function getSmiteGuruUrl(Player $player): ?string
    {
        if (!$player->getId()) {
            return null;
        }

        return sprintf('https://smite.guru/profile/%d-%s/ranked?season=9', $player->getId(), $player->getName());
    }
}
