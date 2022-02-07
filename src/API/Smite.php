<?php

declare(strict_types=1);

namespace App\API;

use App\Entity\Account;
use App\Entity\AccountInfo;
use App\Entity\Player;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Smite
{
    private SessionInterface $session;
    private HttpClientInterface $client;
    private string $devId;
    private string $authKey;

    private string $baseUrl = 'https://api.smitegame.com/smiteapi.svc/';

    public function __construct(RequestStack $requestStack, HttpClientInterface $client, string $devId, string $authKey)
    {
        $this->session = $requestStack->getSession();
        $this->client = $client;
        $this->devId = $devId;
        $this->authKey = $authKey;
    }

    public function searchAccounts(string $accountName): array
    {
        $accounts = $this->request('searchplayers', $accountName);

        return array_map(static fn (array $data) => Account::createFromData($data), $accounts);
    }

    public function liveMatch(int $playerId): array
    {
        $statuses = $this->request('getplayerstatus', $playerId);
        $status = reset($statuses);

        if ($matchId = $status['Match']) {
            $players = $this->request('getmatchplayerdetails', $matchId);

            return array_map(static fn (array $data) => Player::createFromData($data), $players);
        }

        return [];
    }

    public function searchAccountInfo(array $playerIds): array
    {
        if (!$playerIds) {
            return [];
        }

        return array_map(function (int $playerId) {
            $data = $this->request('getplayer', $playerId);

            return AccountInfo::createFromData($data);
        }, $playerIds);
    }

    private function request(string $action, string|int ...$arguments): array
    {
        if ($action !== 'createsession') {
            $this->checkSession();
        }

        $timestamp = (new \DateTime('now', new \DateTimeZone('UTC')))->format('YmdHis');
        $signature = md5($this->devId . $action . $this->authKey . $timestamp);

        // createsession = devId + signature + timestamp
        // others = devId + signature + sessionId + timestamp + arguments
        $arguments = array_merge([$timestamp], $arguments);
        if ($sessionId = $this->session->get('session_id')) {
            array_unshift($arguments, $sessionId);
        }

        $url = $this->baseUrl . $action . "json/{$this->devId}/{$signature}/" . implode('/', $arguments);

        $response = $this->client->request('GET', $url);

        return json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }

    private function checkSession()
    {
        if (
            $this->session->get('session_id')
            && ($this->session->get('session_ttl') > (new \DateTime())->format('U'))
        ) {
            return;
        }

        $this->session->remove('session_id');
        $this->session->remove('session_ttl');

        $result = $this->request('createsession');

        $this->session->set('session_id', $result['session_id']);
        $this->session->set('session_ttl', (new \DateTime('+14 minutes'))->format('U'));
    }
}
