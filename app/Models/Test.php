<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Test
 * 
 * @property int $id
 * @property string $name
 * @property int|null $status
 *
 * @package App\Models
 */
class Test extends Model
{
	protected $table = 'test';
	public $timestamps = false;

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'status'
	];
}
