<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trade extends Model
{
	use SoftDeletes;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'trades';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'product_id', 'buy_price_value', 'sell_price_value', 'fee', 'counts', 'profit_value', 'is_gain', 'user_id', 'note', 'buy_at', 'sell_at'
	];

	public function product()
	{
		return $this->belongsTo('App\Product');
	}
}
