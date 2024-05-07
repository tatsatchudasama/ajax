<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ajax_2 extends Model
{
    use HasFactory;

    protected $table = "ajax_2";
    protected $fillable = [
        'name',
        'email'
    ];
}
