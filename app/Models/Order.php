<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * 
 * @property int $id
 * @property int $purchase_order_id
 * @property int $stock_id
 * @property int $amount
 * @property float $received_priceunit
 * @property int $received_price
 * @property float $price
 * 
 * @property PurchaseOrder $purchase_order
 * @property Stock $stock
 *
 * @package App\Models
 */
class Order extends Model
{
	protected $table = 'orders';
	public $timestamps = false;

	protected $casts = [
		'purchase_order_id' => 'int',
		'stock_id' => 'int',
		'amount' => 'int',
		'received_priceunit' => 'float',
		'received_price' => 'int',
		'price' => 'float'
	];

	protected $fillable = [
		'purchase_order_id',
		'stock_id',
		'amount',
		'received_priceunit',
		'received_price',
		'price'
	];

	public function purchase_order()
	{
		return $this->belongsTo(PurchaseOrder::class);
	}

	public function stock()
	{
		return $this->belongsTo(Stock::class);
	}
}
