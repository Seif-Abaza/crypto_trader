<?php
declare(strict_types=1);

namespace App\Client\Coinbase;

use GuzzleHttp\Client as HttpClient;

class Client
{

    /** @var string */
    private $key;

    /** @var string */
    private $secret;

    /** @var string */
    private $passphrase;

    /** @var string */
    private $baseUrl;

    /** @var int */
    private $requestTimestamp;

    /** @var string */
    private $method;

    /** @var array|string */
    private $dataToRequest = '';

    /** @var string */
    private $uri;

    public function __construct() {

        $this->key = getenv('PRO_COINBASE_API_KEY');
        $this->secret = getenv('PRO_COINBASE_SECRET');
        $this->passphrase = getenv('PRO_COINBASE_PASSPHRASE');

        if (getenv('PRO_COINBASE_TEST') === 'false') {
            $this->baseUrl = getenv('PRO_COINBASE_API_URL');
        } else {
            $this->baseUrl = getenv('PRO_COINBASE_SANDOBX_API_URL');
        }

        $this->requestTimestamp = time();
    }

    /**
     * Funkcia na generovanie SIGN stringu do hlavicky requestu
     *
     * @return string
     */
    private function getSignature() {
        $body = is_array($this->dataToRequest) ? json_encode($this->dataToRequest) : $this->dataToRequest;

        $hash = $this->requestTimestamp . $this->method . $this->uri . $body;

        return base64_encode(hash_hmac('sha256', $hash, base64_decode($this->secret), true));
    }

    private function getRequestHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'CB-ACCESS-KEY' => $this->key,
            'CB-ACCESS-TIMESTAMP' => $this->requestTimestamp,
            'CB-ACCESS-PASSPHRASE' => $this->passphrase,
            'CB-ACCESS-SIGN' => $this->getSignature(),
        ];
    }

    public function createPost(string $uri, array $data): array
    {
        $this->method = 'POST';
        $this->dataToRequest = $data;
        $this->uri = $uri;

        $client = new HttpClient(['base_uri' => $this->baseUrl, 'headers' => $this->getRequestHeaders()]);

        $response = $client->post($this->uri, ['json' => $this->dataToRequest]);

        $data = [];

        $data['body'] = json_decode($response->getBody()->getContents(), true);
        $data['status_code'] = $response->getStatusCode();

        return $data;
    }

    public function createGet(string $uri): array
    {
        $this->method = 'GET';
        $this->uri = $uri;

        $client = new HttpClient(['base_uri' => $this->baseUrl, 'headers' => $this->getRequestHeaders()]);

        $response = $client->get($this->uri);

        $data['body'] = json_decode($response->getBody()->getContents());
        $data['status_code'] = $response->getStatusCode();

        return $data;
    }

    public function createDelete(string $uri, array $data = []): array
    {
        $this->method = 'DELETE';
        $this->uri = $uri;

        $client = new HttpClient(['base_uri' => $this->baseUrl, 'headers' => $this->getRequestHeaders()]);

        $response = $client->delete($this->uri);

        $data = [];

        $data['body'] = json_decode($response->getBody()->getContents());
        $data['status_code'] = $response->getStatusCode();

        return $data;
    }
}