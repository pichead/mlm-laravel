<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PurchaseOrder
 * 
 * @property int $id
 * @property string $purchase_no
 * @property int $year
 * @property Carbon $created_at
 * @property int $buyer_id
 * @property int $seller_id
 * @property bool $visible
 * @property int $isPaid
 * @property int $payment_method_id
 * @property string|null $seller_comment
 * @property string|null $buyer_comment
 * @property int $status_id
 * @property int|null $user_bank_id
 * @property Carbon|null $pay_date
 * @property Carbon|null $pay_time
 * @property float|null $pay_price
 * 
 * @property PaymentMethod $payment_method
 * @property PurchaseOrderStatus $purchase_order_status
 * @property UserBank $user_bank
 * @property Collection|Order[] $orders
 *
 * @package App\Models
 */
class PurchaseOrder extends Model
{
	protected $table = 'purchase_orders';
	public $timestamps = false;

	protected $casts = [
		'year' => 'int',
		'buyer_id' => 'int',
		'seller_id' => 'int',
		'visible' => 'bool',
		'isPaid' => 'int',
		'payment_method_id' => 'int',
		'status_id' => 'int',
		'user_bank_id' => 'int',
		'pay_price' => 'float'
	];

	protected $dates = [
		'pay_date',
		'pay_time'
	];

	protected $fillable = [
		'purchase_no',
		'year',
		'buyer_id',
		'seller_id',
		'visible',
		'isPaid',
		'payment_method_id',
		'seller_comment',
		'buyer_comment',
		'status_id',
		'user_bank_id',
		'pay_date',
		'pay_time',
		'pay_price'
	];

	public function payment_method()
	{
		return $this->belongsTo(PaymentMethod::class);
	}

	public function purchase_order_status()
	{
		return $this->belongsTo(PurchaseOrderStatus::class, 'status_id');
	}

	public function user_bank()
	{
		return $this->belongsTo(UserBank::class);
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}
}
