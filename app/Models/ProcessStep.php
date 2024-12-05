<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessStep extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'processsteps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'step_name',
        'process_id',
        'delete_by',
        'create_by',
        'description',
    ];

    /**
     * Get the process that owns the process step.
     */
    public function process()
    {
        return $this->belongsTo(Process::class);
    }

    public function tasks()
    {
        return $this->hasMany(ProcessTask::class, 'step_id')->notDeleted() ;
    }
}
