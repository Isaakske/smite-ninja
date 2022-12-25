<?php

declare(strict_types=1);

namespace App\API;

use App\Entity\Account;
use App\Entity\AccountInfo;
use App\Entity\MatchInfo;
use App\Services\MatchHelper;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Smite
{
    private SessionInterface $session;
    private HttpClientInterface $client;
    private MatchHelper $matchHelper;
    private string $devId;
    private string $authKey;

    private string $baseUrl = 'https://api.smitegame.com/smiteapi.svc/';

    public function __construct(RequestStack $requestStack, HttpClientInterface $client, MatchHelper $matchHelper, string $devId, string $authKey)
    {
        $this->session = $requestStack->getSession();
        $this->client = $client;
        $this->matchHelper = $matchHelper;
        $this->devId = $devId;
        $this->authKey = $authKey;
    }

    public function accounts(string $accountName): array
    {
        $accounts = $this->request('searchplayers', $accountName);

        return array_map(static fn (array $data) => Account::createFromData($data), $accounts);
    }

    public function liveMatch(int $playerId): MatchInfo|int|null
    {
        $statuses = $this->request('getplayerstatus', $playerId);
        $status = reset($statuses);

        if ($matchId = $status['Match']) {
            $info = $this->request('getmatchplayerdetails', $matchId);

            return $this->matchHelper->createMatchWithTeams($info);
        }

        return (int) $status['status'];
    }

    public function matchDetails(int $matchId): ?MatchInfo
    {
        $info = $this->request('getmatchdetails', $matchId);

        return $this->matchHelper->createMatchWithTeams($info);
    }

    public function accountInfo(int $playerId): AccountInfo
    {
        $data = $this->request('getplayer', $playerId);
        $statusData = $this->request('getplayerstatus', $playerId);

        return AccountInfo::createFromData((array) array_merge(reset($data), reset($statusData)));
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
        $arguments = array_merge([$this->devId, $signature, $timestamp], $arguments);
        if ($sessionId = $this->session->get('session_id')) {
            array_splice($arguments, 2, 0, $sessionId);
        }

        $url = $this->baseUrl . $action . 'json/' . implode('/', $arguments);

        $response = $this->client->request('GET', $url);

        return json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }

    private function checkSession(): void
    {
        if (
            $this->session->get('session_id')
            && ($this->session->get('session_ttl') > (new \DateTime())->format('U'))
        ) {
            return;
        }

        $this->session->remove('session_id');

        $result = $this->request('createsession');

        $this->session->set('session_id', $result['session_id']);
        $this->session->set('session_ttl', (new \DateTime('+14 minutes'))->format('U'));
    }
}
