<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'about',
    ];

    protected $casts = [
        'admin' => 'boolean'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function getAvatarAttribute($value)
    {
        if (empty($value))
            return $this->gravatar($this->attributes['email']);
    }
}
