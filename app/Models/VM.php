<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VM extends Model
{
    use HasFactory;

    protected $table = 'vm_lists';

    protected $fillable = [
        'name',
        'api_key',
        'last_handshake',
        'delete_by',
        'create_by',
    ];
}
