<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * 
 * @property int $ID
 * @property int $payment_id
 * @property Carbon $time
 * @property int $price
 * @property string $payment_status
 *
 * @package App\Models
 */
class Payment extends Model
{
	protected $table = 'payment';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'payment_id' => 'int',
		'price' => 'int'
	];

	protected $dates = [
		'time'
	];

	protected $fillable = [
		'payment_id',
		'time',
		'price',
		'payment_status'
	];
}
