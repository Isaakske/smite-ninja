<?php

declare(strict_types=1);

namespace App\Form\Data;

class AccountSearchData
{
    private ?string $accountName;

    public function __construct(string $accountName = null)
    {
        $this->accountName = $accountName;
    }

    public function getAccountName(): ?string
    {
        return $this->accountName;
    }

    public function setAccountName(?string $accountName): void
    {
        $this->accountName = $accountName;
    }
}
