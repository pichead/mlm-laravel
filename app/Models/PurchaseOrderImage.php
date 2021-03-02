<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PurchaseOrderImage
 * 
 * @property int $id
 * @property int $purchase_order_id
 * @property Carbon $created_at
 * @property string $name
 * @property string|null $path
 * @property string|null $extension
 *
 * @package App\Models
 */
class PurchaseOrderImage extends Model
{
	protected $table = 'purchase_order_images';
	public $timestamps = false;

	protected $casts = [
		'purchase_order_id' => 'int'
	];

	protected $fillable = [
		'purchase_order_id',
		'name',
		'path',
		'extension'
	];
}
