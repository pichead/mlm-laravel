<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PurchaseOrderStatus
 * 
 * @property int $id
 * @property string $name
 * 
 * @property Collection|PurchaseOrder[] $purchase_orders
 *
 * @package App\Models
 */
class PurchaseOrderStatus extends Model
{
	protected $table = 'purchase_order_status';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function purchase_orders()
	{
		return $this->hasMany(PurchaseOrder::class, 'status_id');
	}
}
