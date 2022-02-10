<?php

declare(strict_types=1);

namespace App\Controller;

use App\API\Smite;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{
    #[Route('/profile/{playerId}', name: 'player_profile', methods: ['GET'])]
    #[Template]
    public function profile(int $playerId, Smite $smite): array
    {
        $accountInfos = $smite->accountInfo([$playerId]);
        $accountInfo = reset($accountInfos);

        return [
            'account' => $accountInfo,
        ];
    }
}
