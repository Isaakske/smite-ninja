<?php

declare(strict_types=1);

namespace App\Entity;

class MatchInfo
{
    private int $id;
    private Mode $mode;
    private ?int $winner;
    private array $teams = [];

    public function __construct(int $id, Mode $mode, ?int $winner)
    {
        $this->id = $id;
        $this->mode = $mode;
        $this->winner = $winner;
    }

    public static function creareFromData(array $data): self
    {
        return new self(
            (int) $data['Match'],
            Mode::createFromData($data),
            $data['Winning_TaskForce'] ?? null,
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMode(): Mode
    {
        return $this->mode;
    }

    public function getWinner(): ?int
    {
        return $this->winner;
    }

    public function getTeams(): array
    {
        return $this->teams;
    }

    public function setTeams(array $teams): void
    {
        $this->teams = $teams;
    }
}
