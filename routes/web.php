<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\CoinbaseExchange;
use GuzzleHttp\Client;

Route::get('/', function () {
    return view('welcome');
});

/** All AUTH routes /login, /logout, etc. */
Auth::routes();

Route::get('/api', function ()
{
	$test = false;

	if (!$test) {
		$baseUri = getenv('PRO_COINBASE_API_URL');
	} else {
		$baseUri = getenv('PRO_COINBASE_SANDOBX_API_URL');
	}

	$usedTimestamp = time();

	$coinbaseExchange = new CoinbaseExchange(
		getenv('PRO_COINBASE_API_KEY'),
		getenv('PRO_COINBASE_SECRET'),
		getenv('PRO_COINBASE_PASSPHRASE')
	);

	$sign = $coinbaseExchange->signature(
		'/orders',
		['size' => 0.01, 'price' => 0.1, 'side' => 'buy', 'product_id' => 'BTC-EUR'],
		$usedTimestamp,
		'POST'
	);

	$headers = [
		'CB-ACCESS-KEY' => getenv('PRO_COINBASE_API_KEY'),
		'CB-ACCESS-SIGN' => $sign,
		'CB-ACCESS-TIMESTAMP' => $usedTimestamp,
		'CB-ACCESS-PASSPHRASE' => getenv('PRO_COINBASE_PASSPHRASE'),
		'Content-Type' => 'application/json',
	];

	$client = new Client(['base_uri' => $baseUri, 'headers' => $headers]);

	$response = $client->post('/orders', [
		'form_params' => [
			'size' => 0.01, 'price' => 0.1, 'side' => 'buy', 'product_id' => 'BTC-EUR'
		]
	]);

	$body = $response->getBody()->getContents();

	return response()->json(json_decode($body));

//	dd();
});

Route::group(['middleware' => ['auth']], function () {

	Route::get('/home', 'HomeController@index')->name('home');

});
