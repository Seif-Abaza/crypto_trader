<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	use SoftDeletes;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'products';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'external_product_id', 'name', 'description', 'from_currency_id', 'to_currency_id'
	];

	public function fromCurrency()
	{
		return $this->belongsTo('App\Currency', 'products_from_currency_id_foreign');
	}

	public function toCurrency()
	{
		return $this->belongsTo('App\Currency', 'products_to_currency_id_foreign');
	}

	public function trade()
	{
		return $this->hasMany('App\Trade');
	}
}
