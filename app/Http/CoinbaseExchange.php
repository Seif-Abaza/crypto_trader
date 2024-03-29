<?php


namespace App\Http;


class CoinbaseExchange
{
	/** @var string */
	private $key;

	/** @var string */
	private $secret;

	/** @var string */
	private $passphrase;

	public function __construct(string $key, string $secret, string $passphrase) {
		$this->key = $key;
		$this->secret = $secret;
		$this->passphrase = $passphrase;
	}

	public function signature($request_path = '', $body = '', $timestamp = false, $method = 'GET') {
		$body = is_array($body) ? json_encode($body) : $body;
		$timestamp = $timestamp ? $timestamp : time();

		$what = $timestamp . $method . $request_path . $body;

		return base64_encode(hash_hmac('sha256', $what, base64_decode($this->secret), true));
	}
}