<?php

declare(strict_types=1);

namespace App\Controller;

use App\API\Smite;
use App\Entity\Player;
use App\Form\Data\PlayerSearchData;
use App\Form\Type\PlayerSearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{
    #[Route('/', name: 'player_search', methods: ['GET', 'POST'])]
    #[Template]
    public function search(Request $request, Smite $smite): array|RedirectResponse
    {
        $data = new PlayerSearchData();

        $form = $this->createForm(PlayerSearchType::class, $data);

        if ($request->getMethod() === Request::METHOD_POST) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                if ($playerName = $data->getPlayerName()) {
                    $playerData = $smite->searchPlayers($playerName);

                    $matchingPlayers = array_filter($playerData, static fn (array $data) => $data['Name'] === $playerName);

                    if (count($matchingPlayers) === 1) {
                        $player = reset($matchingPlayers);

                        return $this->redirectToRoute('match_live', ['playerId' => $player['player_id']]);
                    }

                    $players = array_map(static fn (array $data) => Player::createFromData($data), $playerData);
                }
            }
        }

        return [
            'form' => $form->createView(),
            'players' => $players ?? [],
        ];
    }
}
