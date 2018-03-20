<?php

declare(strict_types=1);

namespace App\Service\Api;

use App\Entity\Status;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use Nette\Utils\Json;

/**
 * Class UserClient
 * @package App\Service\Api
 */
class UserClient
{
    const METHOD_POST = \Symfony\Component\HttpFoundation\Request::METHOD_POST,
        METHOD_GET = \Symfony\Component\HttpFoundation\Request::METHOD_GET;

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
    public function __construct(bool $sandbox = FALSE)
    {
        $this->sandbox = $sandbox;
        $this->client = new Client([
            'base_uri' => 'http://oxy.local/api/v1/',
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

        $request = new Request(self::METHOD_POST, $this->client->getConfig('base_uri') . 'user', [],  Json::encode($userData, true));

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
}
