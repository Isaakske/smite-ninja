<?php

declare(strict_types=1);

namespace App\Entity;

class AccountInfo
{
    private int $id;
    private string $name;
    private int $level;
    private int $rank;
    private int $mmr;
    private int $wins;
    private int $losses;
    private int $ratio;
    private int $status;

    public function __construct(int $id, string $name, int $level, int $rank, int $mmr, int $wins, int $losses, int $ratio, int $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->level = $level;
        $this->rank = $rank;
        $this->mmr = $mmr;
        $this->wins = $wins;
        $this->losses = $losses;
        $this->ratio = $ratio;
        $this->status = $status;
    }

    public static function createFromData(array $data): self
    {
        $wins = (int) $data['RankedConquest']['Wins'];
        $losses = (int) $data['RankedConquest']['Losses'];
        $total = $wins + $losses;

        return new self(
            (int) $data['Id'],
            $data['hz_player_name'],
            (int) $data['Level'],
            (int) $data['RankedConquest']['Tier'],
            (int) $data['RankedConquest']['Rank_Stat'],
            $wins,
            $losses,
            $total ? (int) round(($wins / $total) * 100) : 0,
            (int) $data['status']
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        if (str_contains($name, ']')) {
            $name = str_replace(']', '] ', $name);
        }

        $this->name = $name;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    public function getRank(): int
    {
        return $this->rank;
    }

    public function setRank(int $rank): void
    {
        $this->rank = $rank;
    }

    public function getMmr(): int
    {
        return $this->mmr;
    }

    public function setMmr(int $mmr): void
    {
        $this->mmr = $mmr;
    }

    public function getWins(): int
    {
        return $this->wins;
    }

    public function setWins(int $wins): void
    {
        $this->wins = $wins;
    }

    public function getLosses(): int
    {
        return $this->losses;
    }

    public function setLosses(int $losses): void
    {
        $this->losses = $losses;
    }

    public function getRatio(): int
    {
        return $this->ratio;
    }

    public function setRatio(int $ratio): void
    {
        $this->ratio = $ratio;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
}
