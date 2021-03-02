<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserMailForward
 * 
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $forward_email
 *
 * @package App\Models
 */
class UserMailForward extends Model
{
	protected $table = 'user_mail_forward';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'name',
		'forward_email'
	];
}
