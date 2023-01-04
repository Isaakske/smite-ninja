<?php

declare(strict_types=1);

namespace App\Entity;

class Player extends AccountInfo
{
    private int $team;
    private God $god;
    private int $godLevel;
    private Stats $stats;

    public function __construct(int $id, string $name, int $level, int $masteryLevel, string $createdAtString, int $team, God $god, int $godLevel, Stats $stats)
    {
        parent::__construct($id, $name, $level, $masteryLevel, $createdAtString);

        $this->team = $team;
        $this->god = $god;
        $this->godLevel = $godLevel;
        $this->stats = $stats;
    }

    public static function createFromData(array $data): self
    {
        $godLevel = ((int) $data['GodLevel']) - 1;
        if ($godLevel < 0) {
            $godLevel = 0;
        }

        return new self(
            (int) $data['playerId'],
            $data['playerName'],
            (int) $data['Account_Level'],
            (int) $data['Account_Gods_Played'],
            $data['playerCreated'],
            (int) $data['taskForce'],
            God::createFromData($data),
            $godLevel,
            Stats::createForMatch($data)
        );
    }

    public function getTeam(): int
    {
        return $this->team;
    }

    public function getGod(): God
    {
        return $this->god;
    }

    public function getGodLevel(): ?int
    {
        return $this->godLevel;
    }

    public function getStats(): Stats
    {
        return $this->stats;
    }
}
