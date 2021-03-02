<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentMethod
 * 
 * @property int $id
 * @property string $name
 * 
 * @property Collection|PurchaseOrder[] $purchase_orders
 *
 * @package App\Models
 */
class PaymentMethod extends Model
{
	protected $table = 'payment_methods';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function purchase_orders()
	{
		return $this->hasMany(PurchaseOrder::class);
	}
}
