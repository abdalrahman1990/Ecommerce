<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminResetPasswordNotification as ResetPasswordNotification;

class Admin extends Authenticatable
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
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the User Avatar (profile image associated with user's email)
     * 
     * @return string
     */
    public function getGravatarAttribute()
    {
        //Creating a Hash
        $hash = md5(strtolower(trim($this->email)));
        
        //Getting the admin avatar with gravatar
        return "http://www.gravatar.com/avatar/{$hash}"."?d=mp";
    }
}
