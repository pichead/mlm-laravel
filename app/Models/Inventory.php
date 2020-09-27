<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Inventory
 * 
 * @property int $ID
 * @property string $ProductList
 * @property int $price
 *
 * @package App\Models
 */
class Inventory extends Model
{
	protected $table = 'inventory';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'price' => 'int'
	];

	protected $fillable = [
		'ProductList',
		'price'
	];
}
