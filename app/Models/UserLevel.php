<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserLevel
 * 
 * @property int $id
 * @property string $name
 * @property int $level
 *
 * @package App\Models
 */
class UserLevel extends Model
{
	protected $table = 'user_level';
	public $timestamps = false;

	protected $casts = [
		'level' => 'int'
	];

	protected $fillable = [
		'name',
		'level'
	];
}
