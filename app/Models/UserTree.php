<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserTree
 * 
 * @property int $id
 * @property int $parent_id
 * @property int $child_id
 *
 * @package App\Models
 */
class UserTree extends Model
{
	protected $table = 'user_tree';
	public $timestamps = false;

	protected $casts = [
		'parent_id' => 'int',
		'child_id' => 'int'
	];

	protected $fillable = [
		'parent_id',
		'child_id'
	];
}
