<?php

declare(strict_types=1);

namespace App\Service\Api;

use App\Entity\Status;
use App\Entity\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use JMS\Serializer\SerializerInterface;
use Nette\Utils\Json;

/**
 * Class UserClient
 * @package App\Service\Api
 */
class UserClient
{
    const METHOD_POST = \Symfony\Component\HttpFoundation\Request::METHOD_POST,
        METHOD_GET = \Symfony\Component\HttpFoundation\Request::METHOD_GET,
        CONFIG_BASE_URI = 'base_uri';

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var bool
     */
    private $sandbox;

    /**
     * @var Client
     */
    private $client;

    /**
     * UserClient constructor.
     * @param bool $sandbox
     */
    public function __construct(SerializerInterface $serializer, bool $sandbox = FALSE)
    {
        $this->serializer = $serializer;
        $this->sandbox = $sandbox;
        $this->client = new Client([
            self::CONFIG_BASE_URI => 'http://oxy.local/api/v1/',
            'timeout' => 2.0,
            'http_errors' => true,
        ]);
    }

    /**
     * @param array $userData
     * @throws \Exception
     */
    public function createUser(array $userData): void
    {
        /*
         * Due json encoding
         */
        if (!is_string($userData['role'])) {
            $userData['role'] = (string) $userData['role'];
        }

        $request = new Request(self::METHOD_POST, $this->client->getConfig(self::CONFIG_BASE_URI) . 'createUser', [],  Json::encode($userData, true));

        try {
            $response = $this->client->send($request);
            $body = Json::decode($response->getBody());

            if ($body->status === Status::STATUS_ERROR) {
                throw new \Exception($body->message);
            }
        } catch (ServerException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param int $page
     * @return array
     * @throws \Exception
     */
    public function userList(int $page = 1): array
    {
        $request = new Request(self::METHOD_GET, $this->client->getConfig(self::CONFIG_BASE_URI) . 'userList' . $this->getPagePath($page));
        try {
            $response = $this->client->send($request);
            $users = [];
            $data = Json::decode($response->getBody(), true);

            foreach ($data['users'] as $userData) {
                // A bit tricky workaround to deserialize entities
                $userTmp = Json::encode($userData);
                $user = $this->serializer->deserialize($userTmp, User::class, 'json');
                $users[] = $user;
            }

            return $users;

        } catch (ServerException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param int $page
     * @return string
     */
    private function getPagePath(int $page): string
    {
        return $page > 1 ? "/{$page}" : '';
    }
}
