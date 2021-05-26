<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;

    protected $table = 'lecturers';

    protected $fillable = [
        'user_id',
        'nip',
        'faculty',
        'department',
    ];

    public function user(){
        return $this->belogsTo(User::class);
    }
}
