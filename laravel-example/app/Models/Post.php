<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDelete;

class Post extends Model
{
    use HasFactory, SoftDelete;

    protected $table = 'table_posts';
    protected $fillable = ['title', 'content', 'status', 'piublished_at', 'conver_image', 'tag', 'meta'];

    protected $casts = [
        'punlished_at' => 'datetime',
        'tags' => 'array',
        'meta' => 'meta'
    ];

    public function categories(){
        // Tabla pivote
        return $this->belongsToMany(Category::class)->using(CategoryPost::class)->withTimestamps();
    }
}
