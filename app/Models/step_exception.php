<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class step_exception extends Model
{
    use HasFactory;
    protected $table = 'process_step_exceptions';
    protected $fillable = [
        'name',
        'description',
        'step_id',
        'create_by',
        'delete_by',
    ];
}
