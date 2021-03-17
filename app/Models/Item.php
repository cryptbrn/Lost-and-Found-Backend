<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'category',
        'location',
        'picture',
    ];



    public function post()
    {
        return $this->hasOne(Post::class);
    }
}
