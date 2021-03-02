<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Bank
 * 
 * @property int $id
 * @property string $name
 * @property bool $visible
 *
 * @package App\Models
 */
class Bank extends Model
{
	protected $table = 'banks';
	public $timestamps = false;

	protected $casts = [
		'visible' => 'bool'
	];

	protected $fillable = [
		'name',
		'visible'
	];
}
