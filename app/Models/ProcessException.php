<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessException extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'processexceptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exception_name',
        'confidence',
        'order',
        'is_loop',
        'is_stop_task',
        'value',
        'step_id',
        'task_action',
        'delete_by',
        'create_by',
        'description',
    ];

    /**
     * Get the step that owns the process task.
     */
    public function step()
    {
        return $this->belongsTo(ProcessStep::class);
    }

    public function img()
    {
        return $this->hasMany(Fileimg::class, 'process_task_id', 'id');
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('delete_by', 1);
    }
}
