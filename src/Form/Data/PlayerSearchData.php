<?php

declare(strict_types=1);

namespace App\Form\Data;

class PlayerSearchData
{
    private ?string $playerName;

    public function __construct(string $playerName = null)
    {
        $this->playerName = $playerName;
    }

    public function getPlayerName(): ?string
    {
        return $this->playerName;
    }

    public function setPlayerName(?string $playerName): void
    {
        $this->playerName = $playerName;
    }
}
