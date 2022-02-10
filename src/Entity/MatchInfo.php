<?php

declare(strict_types=1);

namespace App\Entity;

class MatchInfo
{
    private int $id;
    private int $mode;
    private ?int $winner;
    private array $teams = [];

    public function __construct(int $id, int $mode, ?int $winner)
    {
        $this->id = $id;
        $this->mode = $mode;
        $this->winner = $winner;
    }

    public static function creareFromData(array $data): self
    {
        return new self(
            (int) $data['Match'],
            (int) ($data['Queue'] ?? $data['match_queue_id']),
            $data['Winning_TaskForce'] ?? null,
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

    public function getMode(): int
    {
        return $this->mode;
    }

    public function setMode(int $mode): void
    {
        $this->mode = $mode;
    }

    public function getWinner(): ?int
    {
        return $this->winner;
    }

    public function setWinner(?int $winner): void
    {
        $this->winner = $winner;
    }

    public function getTeams(): array
    {
        return $this->teams;
    }

    public function setTeams(array $teams): void
    {
        $this->teams = $teams;
    }

    public function getPlayers(): array
    {
        return array_merge(...$this->getTeams());
    }
}
