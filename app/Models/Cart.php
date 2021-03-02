<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cart
 * 
 * @property int $id
 * @property int $user_id
 * @property int $stock_id
 * @property int $amount
 *
 * @package App\Models
 */
class Cart extends Model
{
	protected $table = 'cart';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'stock_id' => 'int',
		'amount' => 'int'
	];

	protected $fillable = [
		'user_id',
		'stock_id',
		'amount'
	];
}
