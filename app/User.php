<?php

namespace App;

use App\Models\mongo\Company;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    public function company()
    {
        return $this->belongsTo(Company::class)->withDefault([
            'title' => 'Не назначена'
        ]);
    }
}
