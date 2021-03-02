<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Stock
 * 
 * @property int $id
 * @property string $name
 * @property float $received_price
 * @property float $spent_price
 * @property string $spent_unit
 * @property bool $visible
 * @property int|null $amount
 * @property int|null $type
 * 
 * @property Collection|Order[] $orders
 * @property Collection|Price[] $prices
 * @property Collection|StockHistory[] $stock_histories
 *
 * @package App\Models
 */
class Stock extends Model
{
	protected $table = 'stocks';
	public $timestamps = false;

	protected $casts = [
		'received_price' => 'float',
		'spent_price' => 'float',
		'visible' => 'bool',
		'amount' => 'int',
		'type' => 'int'
	];

	protected $fillable = [
		'name',
		'received_price',
		'spent_price',
		'spent_unit',
		'visible',
		'amount',
		'type'
	];

	public function orders()
	{
		return $this->hasMany(Order::class);
	}

	public function prices()
	{
		return $this->hasMany(Price::class);
	}

	public function stock_histories()
	{
		return $this->hasMany(StockHistory::class);
	}
}
