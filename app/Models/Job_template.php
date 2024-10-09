<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job_template extends Model
{
    use HasFactory;
    protected $table = 'job_templates';
    protected $fillable = [
        'name',
        'process_id',
        'description',
        'vm_id',
        'delete_by',
        'create_by',
    ];

    public function process()
    {
        return $this->belongsTo(Process::class);
    }
    
    public function vm()
    {
        return $this->belongsTo(VM::class);
    }
}
