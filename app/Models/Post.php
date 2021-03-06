<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'status',
        'is_deleted',

    ];

    public function user(){
        return $this->belogsTo(User::class);
    }

    public function item()
    {
        return $this->hasOne(Item::class);
    }

}
