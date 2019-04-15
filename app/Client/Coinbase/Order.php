<?php
declare(strict_types=1);

namespace App\Client\Coinbase;


class Order
{

    /** @var Client */
    private $client;

    public function __construct() {

        $this->client = new Client();
    }

    public function createOrder(array $data): array
    {
        $uri = '/orders';

        return $this->client->createPost($uri, $data);
    }

    public function getOrders(array $filter = [])
    {
        $uri = '/orders';

        return $this->client->createGet($uri);
    }

    public function getOrder(string $externalOrderId)
    {
        $uri = '/orders/' . $externalOrderId;

        return $this->client->createGet($uri);
    }

    public function cancelOrder(string $externalOrderId)
    {
        $uri = '/orders/' . $externalOrderId;

        return $this->client->createDelete($uri);
    }

}