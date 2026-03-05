<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
     protected $fillable = [
       'featured_image', 'post_title', 'blog_post', 'title', 'description',
       'tags', 'category', 'slug', 'author'
    ];
}
