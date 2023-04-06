<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'created_by', 'updated_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id'); //parameter kedua adalah milik model Post, parameter ketiga adalah milik model User
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id'); //parameter kedua adalah milik model Comment, parameter ketiga adalah milik model Post
    }

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
