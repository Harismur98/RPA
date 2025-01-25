<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fileimg extends Model
{
    use HasFactory;
    protected $table = 'file_img';
    protected $fillable = [
        'process_task_id',
        'filename',
        'original_name',
        'file_path',
        'file_index',
        'process_exception_id'
    ];

}
