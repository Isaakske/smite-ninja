<?php

declare(strict_types=1);

namespace App\Controller;

use App\API\Smite;
use App\Entity\Player;
use App\Form\Data\PlayerSearchData;
use App\Form\Type\PlayerSearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{
    #[Route('/', name: 'player_search', methods: ['GET', 'POST'])]
    #[Template]
    public function search(Request $request, Smite $smite): Response
    {
        $data = new PlayerSearchData($request->cookies->get('player_name'));

        $form = $this->createForm(PlayerSearchType::class, $data);

        if ($request->getMethod() === Request::METHOD_POST) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                if ($playerName = $data->getPlayerName()) {
                    $cookie = Cookie::create('player_name', $playerName, new \DateTime('+14 days'));

                    $playerData = $smite->searchPlayers($playerName);

                    $matchingPlayers = array_filter($playerData, static fn (array $data) => $data['Name'] === $playerName);

                    if (count($matchingPlayers) === 1) {
                        $player = reset($matchingPlayers);

                        $response = $this->redirectToRoute('match_live', ['playerId' => $player['player_id']]);
                        $response->headers->setCookie($cookie);

                        return $response;
                    }

                    $players = array_map(static fn (array $data) => Player::createFromData($data), $playerData);
                }
            }
        }

        $response = $this->render('player/search.html.twig', [
            'form' => $form->createView(),
            'players' => $players ?? [],
        ]);

        if (isset($cookie)) {
            $response->headers->setCookie($cookie);
        }

        return $response;
    }
}
