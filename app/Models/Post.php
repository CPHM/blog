<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'summary',
        'content'
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function categories()
    {
        $this->belongsToMany(Category::class);
    }
}
