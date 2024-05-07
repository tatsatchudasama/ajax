<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ajax_curd extends Model
{
    use HasFactory;

    protected $table = 'ajax_curds';

    protected $fillable = [
        'name',
        'price',
        'price_percentage',
        'total',
        'date',
    ];

}
