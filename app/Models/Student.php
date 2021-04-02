<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nim',
        'faculty',
        'department',
        'batch',
    ];

    public function user(){
        return $this->belogsTo(User::class);
    }
}
