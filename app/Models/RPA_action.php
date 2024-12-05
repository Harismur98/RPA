<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RPA_action extends Model
{
    use HasFactory;

    protected $table = 'rpa_functions';

    protected $fillable = [
        'function_name',
        'delete_by',
        'create_by',
    ];
}