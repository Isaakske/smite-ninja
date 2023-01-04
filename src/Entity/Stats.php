<?php

declare(strict_types=1);

namespace App\Entity;

class Stats
{
    private int $tier;
    private int $mmr;
    private int $wins;
    private int $losses;
    private int $ratio;

    public function __construct(int $tier, int $mmr, int $wins, int $losses)
    {
        $this->tier = $tier;
        $this->mmr = $mmr;
        $this->wins = $wins;
        $this->losses = $losses;

        $total = $wins + $losses;
        $this->ratio = $total ? (int) round(($wins / $total) * 100) : 0;
    }

    public static function createForMatch(array $data): self
    {
        return new self(
            (int) $data['Tier'],
            (int) $data['Rank_Stat'],
            (int) $data['tierWins'],
            (int) $data['tierPoints']
        );
    }

    public static function createForProfile(array $data): self
    {
        return new self(
            (int) $data['Tier'],
            (int) $data['Rank_Stat'],
            (int) $data['Wins'],
            (int) $data['Losses']
        );
    }

    public function getTier(): int
    {
        return $this->tier;
    }

    public function getMmr(): int
    {
        return $this->mmr;
    }

    public function getWins(): int
    {
        return $this->wins;
    }

    public function getLosses(): int
    {
        return $this->losses;
    }

    public function getRatio(): int
    {
        return $this->ratio;
    }
}
