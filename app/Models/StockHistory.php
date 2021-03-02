<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StockHistory
 * 
 * @property int $id
 * @property int $stock_id
 * @property float $cost
 * @property float $price
 * @property Carbon $created_at
 * 
 * @property Stock $stock
 *
 * @package App\Models
 */
class StockHistory extends Model
{
	protected $table = 'stock_history';
	public $timestamps = false;

	protected $casts = [
		'stock_id' => 'int',
		'cost' => 'float',
		'price' => 'float'
	];

	protected $fillable = [
		'stock_id',
		'cost',
		'price'
	];

	public function stock()
	{
		return $this->belongsTo(Stock::class);
	}
}
