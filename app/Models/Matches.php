<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{

    protected $table = 'matches';

    protected $casts = [
        'names' => 'array'
    ];

    protected $fillable = [
        'file_id',
        'names',
        'average_score',
    ];
    use HasFactory;
}
