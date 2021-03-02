<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Price
 * 
 * @property int $id
 * @property int $user_id
 * @property int $stock_id
 * @property int $start_total
 * @property int $end_total
 * @property float $price
 * 
 * @property Stock $stock
 * @property User $user
 *
 * @package App\Models
 */
class Price extends Model
{
	protected $table = 'prices';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'stock_id' => 'int',
		'start_total' => 'int',
		'end_total' => 'int',
		'price' => 'float'
	];

	protected $fillable = [
		'user_id',
		'stock_id',
		'start_total',
		'end_total',
		'price'
	];

	public function stock()
	{
		return $this->belongsTo(Stock::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
