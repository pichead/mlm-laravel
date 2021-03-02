<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\UserLevel;

// use App\Models\User;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function hasAnyLevels($user_level_id, $authorized_levels)
    {
        return in_array($user_level_id, $authorized_levels);
        
    }

    // public function hasAnyLevels($authorized_levels)
    // {
    //     if (is_array($authorized_levels)) {

    //         foreach ($authorized_levels as $authorized_level) {
    //             if ($this->hasLevel($authorized_level)) {
    //                 return true;
    //             }
    //         }

    //     } else {
    //         if ($this->hasLevel($authorized_levels)) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }



    
    public function user_level()
	{
		return $this->belongsTo(UserLevel::class, 'level_id');
    }
    

}
