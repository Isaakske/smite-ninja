<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\API\Smite;
use App\Common\Mapper;
use App\Entity\God;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class IconExtension extends AbstractExtension
{
    private array $godIcons = [];

    private Smite $smite;
    private string $cacheDir;

    public function __construct(Smite $smite, string $cacheDir)
    {
        $this->smite = $smite;
        $this->cacheDir = $cacheDir;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('god_icon', [$this, 'getGodIcon']),
        ];
    }

    public function getGodIcon(int $id): ?string
    {
        $file = $this->cacheDir . '/gods.json';

        if (!$this->godIcons && file_exists($file)) {
            $this->godIcons = json_decode(file_get_contents($file), true, 512, JSON_THROW_ON_ERROR);
        }

        if (!array_key_exists($id, $this->godIcons)) {
            $gods = $this->smite->gods();

            $this->godIcons = Mapper::mapObjects($gods, static fn (God $god) => $god->getId(), static fn (God $god) => $god->getIcon());
            file_put_contents($file, json_encode($this->godIcons, JSON_THROW_ON_ERROR));
        }

        return $this->godIcons[$id] ?? null;
    }
}
