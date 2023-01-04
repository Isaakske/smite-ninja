<?php

declare(strict_types=1);

namespace App\Entity;

class Mode
{
    private int $id;
    private string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function createFromData(array $data): self
    {
        return new self(
            (int) $data['Queue'],
            $data['mapGame']
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
