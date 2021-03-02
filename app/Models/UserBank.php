<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserBank
 * 
 * @property int $id
 * @property int $bank_id
 * @property int $user_id
 * @property string|null $name
 * @property string $account_no
 * @property int $visible
 * 
 * @property Collection|PurchaseOrder[] $purchase_orders
 *
 * @package App\Models
 */
class UserBank extends Model
{
	protected $table = 'user_bank';
	public $timestamps = false;

	protected $casts = [
		'bank_id' => 'int',
		'user_id' => 'int',
		'visible' => 'int'
	];

	protected $fillable = [
		'bank_id',
		'user_id',
		'name',
		'account_no',
		'visible'
	];

	public function purchase_orders()
	{
		return $this->hasMany(PurchaseOrder::class);
	}
}
